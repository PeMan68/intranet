<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Area;
use App\Contact;
use App\Task;
use App\User;
use App\Priority;
use App\IssueComment;
use App\IssueAttachment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreIssue;
use App\Http\Requests\UpdateIssue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Events\Issues\NewIssue;
use App\Events\Issues\UpdatedIssue;
use App\Events\Issues\IssueClosed;
use App\Events\Issues\IssuePaused;
use App\Events\Issues\IssueReopened;
use App\Events\Issues\IssueWaitingForCustomer;
use App\Events\Issues\IssueWaitingForInternal;
use Illuminate\Support\Facades\Log;

class IssuesController extends Controller
{
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
    {
		check_in_issues();
		
		// cleanup task_user table for current user
		$tasks = Task::all();
		Auth::user()->tasks()->sync($tasks);
		$itemsAll = $this->createTableData(
			Issue::with('task','latestComment','userCreate')
				->get()
				->sortByDesc('calculated_prio')
				->flatten()
		);
		$numberOfDaysToShow = setting('days_show_closed_issues');
		$itemsAlsoClosed = $this->createTableData(
			Issue::with('task','latestComment','userCreate')
				->whereNull('timeClosed')
				->orWhere('timeClosed','>',now()->subDays($numberOfDaysToShow))
				->get()
				->sortByDesc('calculated_prio')
				->flatten()
		);

		$fields = collect([]);
		$fields->push(['key'=> 'Info']);
		$fields->push(['key'=> 'Ärende', 'sortable' => true]);
		// $fields->push(['key'=> 'Registrerat', 'sortable' => true]);
		$fields->push(['key'=> 'Senaste_händelse']);
		$fields->push(['key'=> 'Område', 'sortable' => true]);
		$fields->push(['key'=> '.', 'class' => 'text-right']);
		$fields->push(['key'=> 'Kund']);
		$fields->push(['key'=> 'Kontakt']);
		$fields->push(['key'=> 'Rubrik']);

        return view('issues.index', ['itemsAll' => $itemsAll, 'itemsAlsoClosed' => $itemsAlsoClosed, 'fields' => $fields]);
	}

	private function createTableData($issues) 
	{					
        $selected = $issues->map(function ( $item ) {
			if (!is_null($item->latestComment)) {
				$latest_days = date_diff($item->latestComment->updated_at, now())->format('%a');
				$latest_date = date('y-m-d',strtotime($item->latestComment->updated_at));
			} else {
				$latest_days = date_diff($item->created_at, now())->format('%a');
				$latest_date = '';
			}
			if ($latest_days == 0) {
				$latest_days = 'senaste dygnet';
			// } elseif ($latest_days == 1){
			// 	$latest_days = '1 dygn';
			} else {
				$latest_days .= ' dygn';
			}

			if ($item->minutesToCallback() < 0 && is_null($item->timeClosed)) {

				$rowVariant = 'danger';
			} elseif ($item->userCurrentLevel() == 3) {
				$rowVariant = 'primary';
			} elseif ($item->userCurrentLevel() == 2) {
				$rowVariant = 'secondary';
			} else {
				$rowVariant = '';
			}
            return [
				'Id' => $item->id,
                'Ärende' => $item->ticketNumber,
				'Registrerat' => date('y-m-d',strtotime($item->timeInit)),
				'Avslutat' => date('y-m-d', strtotime($item->timeClosed)),
				'Senaste_händelse' => $latest_days,
				'Senaste' => $latest_date,
				'Område' => $item->task->name,
				'finish' => $item->timeClosed,
				'vip' => $item->vip,
				'prio' => $item->prio,
				'pause' => $item->paused,
				'contacted' => $item->timeCustomercallback,
				'Kund' => $item->customer,
				'Kontakt' => $item->customerName,
				'Rubrik' => Str::limit($item->header,30),
				'Ärende_beskrivning' => $item->description,
				'E_post' => $item->customerMail,
				'Telefon' => $item->customerTel,
				'Skapad_av' => $item->userCreate->fullName(),
				'Senaste_kommentar' => $item->latestComment['comment'],
				'wait_Customer' => $item->waitingForCustomer,
				'wait_Internal' => $item->waitingForInternal,

				'_rowVariant' => $rowVariant,
            ];
		});
		return $selected;
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		check_in_issues();
        $areas = Area::all();
        $tasks = Task::all();
		$user = Auth::user();
		$initTime=date('Y-m-d H:i:s');

		return view('issues.create')->with(['areas' => $areas, 'tasks' => $tasks, 'user' => $user, 'timeInit' => $initTime]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function storeFile(Request $request)
	{
		$tmpFileName=$request->file;
		$issue_id = $request->id;
			
			$realFileName=$tmpFileName->getClientOriginalName();
			// $documentExtension = $request->file->getClientOriginalExtension();
			$pathToFile = $tmpFileName->store('public/documents');
			$data['path'] = $pathToFile;
			$data['filename'] = $realFileName;
			$data['user_id'] = Auth::id();
			$data['issue_id'] = $issue_id;
			$document = IssueAttachment::create($data);
		return response()->json($document);
		// return redirect('/issues/', $issue_id)->with('success','Fil uppladdad');
	}

    /**
     * Download the specified resource.
     *
     * @param  \App\IssueAttachment  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadFile($id)
    {
        $document = IssueAttachment::find($id);
		return Storage::download($document->path, $document->filename);
	}
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIssue $request)
    {
		$validatedData = $request->validated();
		$validatedData['userCreate_id'] = Auth::id();
		$validatedData['timeInit'] = $request->timeInit;
		if ($request->has('urgent')) {
			$hours = 0;
		} else {
			// get $hours according to priority-table for this task
			$prio = Task::find($request->task_id)->prio_id;
			$hours = Priority::find($prio)->hours;
		}
		// TODO Enhancement, adjust to working hours according to calendar
		$validatedData['timeEstimatedcallback'] = date('Y-m-d H:i', strtotime(sprintf("+%d hours", $hours))); 
		$validatedData['vip'] = $request->has('vip');
		//build ticketnumber, S+year+number of issues currentyear.
		$validatedData['ticketNumber'] = setting('issue_prefix') . date('y') . sprintf('%03d',Issue::whereYear('created_at', date('Y'))->count() +1);
		
		$issue = Issue::create($validatedData);

		if ($request->has('follow')) {
			$issue->followers()->attach(Auth::id());
		}

		//Send mail to responsible staff and other stuff
		
        if ($request->has('save')) {
			event(new NewIssue($issue, $hours));
			return redirect('/issues')->with('success','Nytt ärende skapat: '.$issue->ticketNumber);
		}
        if ($request->has('saveOpen')) {
			// Key is used to delay email of New Issue and Block mails about updates until key is expired
			$delayMinutes = nextWorkingDateTime(setting('time_disable_update_job'));
			cache([$issue->ticketNumber => true], $delayMinutes);
			event(new NewIssue($issue, $hours));
			return redirect('/issues/'.$issue->id)->with('message','Nytt ärende '.$issue->ticketNumber);
		}
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
		$comments = IssueComment::
			where('issue_id',$issue->id)
			->hasComments()
			->orderBy('checkin', 'desc')
			->get();
			// internal contact means inside Enterprise, ie not customers
		$contacts = Contact::where('internal', 1)->get();		
        $areas = Area::all();
        $tasks = Task::all();
		$users = User::where('active', 1)->get();
		$auth_user = Auth::user();
		$followers = $issue->followers;
		$follow = 0;
		$files = IssueAttachment::
			where('issue_id',$issue->id)
			->get();
		foreach ($followers as $follower) {
			if ($follower->id == Auth::id()) {
				$follow = 1;
			}		
		}

		check_in_issues();
		$issue->refresh();
		$new_comment = check_out_issue($issue);
		$issue->refresh();
		$selected = $contacts->map(function ( $contact ) {
			return [
				'value' => [
					
					'id' => $contact->id,
					'email' => $contact->email,
				],
				'text' => $contact->name,
			];
		});
		$selected->push(['value' => ['id' => 0, 'email' => $issue->customerMail], 'text' => $issue->customerName, ]);
		$users = $users->map(function ($user) {
			if ($user)
			return [
				'id' => $user->id,
				'name' => $user->fullName(),
			];
		});
		return view('issues.show')->with([
			'issue' => $issue, 
			'comments' => $comments,
			'areas' => $areas, 
			'tasks' => $tasks, 
			'users' => $users,
			'auth_user' => $auth_user,
			'followers' => $followers,
			'follow' => $follow,
			'new_comment' => $new_comment,
			'files' => $files,
			'contacts' => $selected,
			]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
		//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIssue $request, Issue $issue)
    {
		if ($request->has('cancel')) {
			return redirect('/issues/'.$issue->id);
		}
		
        if ($request->has('save')) {
			$validatedData = $request->validated();
			$validatedData['vip'] = $request->has('vip');
			$validatedData['paused'] = $request->has('paused');
			if ($request->has('paused')) {
				event(new IssuePaused($issue, 'paused'));
			}
			$validatedData['waitingForCustomer'] = $request->has('waitingForCustomer');
			if ($request->has('waitingForCustomer')) {
				event(new IssueWaitingForCustomer($issue, 'waitingForCustomer'));
			}
			$validatedData['waitingForInternal'] = $request->has('waitingForInternal');
			if ($request->has('waitingForInternal')) {
				event(new IssueWaitingForInternal($issue, 'waitingForInternal'));
			}
			$issue->update($validatedData);
			// event(new UpdatedIssue($issue, $type='header', $issue->getChanges()));
		}
		return redirect('/issues/'.$issue->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        //
    }
	
	public function follow($id)
	{
		$issue = Issue::find($id);
		$issue->followers()->attach(Auth::id());
		return redirect()->back();
	}

	public function add_follower(Request $request)
	{
		$issue = Issue::find($request->issueId);
		// Add follower if not already exists
		if (!$issue->followers->contains($request->user)) {
			$issue->followers()->attach($request->user);
		}
	}
	
	public function unfollow($id)
	{
		$issue = Issue::find($id);
		$issue->followers()->detach(Auth::id());
		return redirect()->back();
	}
	
	public function contacted($id)
	{ 
		$issue = Issue::find($id);
		Issue::whereId($id)->update(['timeCustomercallback' => date('Y-m-d H:i',strtotime(now()))]);
		return redirect()->back();
	}
	
	public function uncontacted($id)
	{
		$issue = Issue::find($id);
		Issue::whereId($id)->update(['timeCustomercallback' => null]);
		return redirect()->back();
	}
	
	public function close($id)
	{

		// $validatedData['timeClosed'] = date('Y-m-d H:i:s');
		$issue = Issue::find($id);
		$issue->update([
		'timeClosed' => date('Y-m-d H:i:s'),
		'paused' => null,
		'waitingForCustomer' => null,
		'waitingForInternal' => null,
		]);
		event(new IssueClosed($issue));
		event(new UpdatedIssue($issue, $type='comment',[]));
		return redirect('/issues');
		
	}

	public function reopen($id)
	{
		$issue = Issue::find($id);
		Issue::whereId($id)->update(['timeClosed' => null]);
		event(new IssueReopened($issue));
		event(new UpdatedIssue($issue, $type='comment', []));
		return redirect()->back();
	}
	
}
