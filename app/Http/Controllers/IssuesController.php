<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Area;
use App\Task;
use App\User;
use App\Priority;
use App\IssueComment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreIssue;
use App\Http\Requests\UpdateIssue;
use Illuminate\Support\Facades\Auth;
use App\Mail\IssueCreated;
use Illuminate\Support\Facades\Mail;
use App\Events\NewIssue;
use App\Events\IssueReopened;
use App\Events\NewIssueComment;
//use App\Jobs\IssueNew;
use Illuminate\Support\Str;

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

        $issues = Issue::with('task','latestComment','userCreate')
					->whereNull('timeClosed')
					->orWhere('timeClosed','>',date('Y-m-d',strtotime('-1 year')))
					->get()
					->sortByDesc('calculated_prio')
					->flatten()
					;
					
        $selected = $issues->map(function ( $item ) {
			if (!is_null($item->latestComment)) {
				$latest_days = date_diff($item->latestComment->updated_at, now())->format('%a');
				$latest_date = date('y-m-d',strtotime($item->latestComment->updated_at));
			} else {
				$latest_days = date_diff($item->created_at, now())->format('%a');
				$latest_date = '';
			}
			if ($latest_days == 0) {
				$latest_days = ' idag';
			} elseif ($latest_days == 1){
				$latest_days = '1 dag';
			} else {
				$latest_days .= ' dagar';
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
				'Senaste_kontakt' => $latest_days,
				'Senaste' => $latest_date,
				'Område' => $item->task->name,
				'finish' => $item->timeClosed,
				'vip' => $item->vip,
				'prio' => $item->prio,
				'wait' => $item->waitingForReply,
				'pause' => $item->paused,
				'contacted' => $item->timeCustomercallback,
				'Kund' => $item->customer,
				'Kontakt' => $item->customerName,
				'Rubrik' => Str::limit($item->header,30),
				'Ärende_beskrivning' => $item->description,
				'E_post' => $item->customerMail,
				'Telefon' => $item->customerTel,
				'Skapad_av' => $item->userCreate->fullName(),
				'Senaste_kommentar' => $item->latestComment['comment_internal'],

				'_rowVariant' => $rowVariant,
            ];
		});

		$fields = collect([]);
		$fields->push(['key'=> 'Info']);
		$fields->push(['key'=> 'Ärende', 'sortable' => true]);
		$fields->push(['key'=> 'Registrerat', 'sortable' => true]);
		$fields->push(['key'=> 'Senaste_kontakt', 'sortable' => true]);
		$fields->push(['key'=> 'Område', 'sortable' => true]);
		$fields->push(['key'=> '.', 'class' => 'text-right']);
		$fields->push(['key'=> 'Kund']);
		$fields->push(['key'=> 'Kontakt']);
		$fields->push(['key'=> 'Rubrik']);

        return view('issues.index', ['products' => $selected, 'fields' => $fields]);
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
		$validatedData['timeEstimatedcallback'] = date('Y-m-d H:i', strtotime(sprintf("+%d hours", $hours))); //Enhancement, adjust to working hours according to calendar
		$validatedData['vip'] = $request->has('vip');
		//build ticketnumber, S+year+number of issues currentyear.
		$validatedData['ticketNumber'] = 'S-' . date('y') . sprintf('%03d',Issue::whereYear('created_at', date('Y'))->count() +1);
        $issue = Issue::create($validatedData);
		
		if ($request->has('follow')) {
			$issue->followers()->attach(Auth::id());
		}

		$task = Task::find($request->task_id);
		//Send mail to responsible staff and other stuff
		event(new NewIssue($issue, $hours));

        if ($request->has('save')) {
			return redirect('/issues')->with('success','Nytt ärende skapat: '.$validatedData['ticketNumber']);
		}
        if ($request->has('saveOpen')) {
			return redirect('/issues/'.$issue->id)->with('success','Nytt ärende '.$validatedData['ticketNumber']);
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
		$Comments = IssueComment::
			where('issue_id',$issue->id)
			->hasComments()
			->get();
				
        $areas = Area::all();
        $tasks = Task::all();
		$users = User::where('active', 1)->get();
		$auth_user = Auth::user();
		$followers = $issue->followers;
		$follow = 0;
		foreach ($followers as $follower) {
			if ($follower->id == Auth::id()) {
				$follow = 1;
			}		
		}

		check_in_issues();
		$issue->refresh();
		$new_comment = check_out_issue($issue);
		$issue->refresh();
		return view('issues.show')->with([
			'issue' => $issue, 
			'comments' => $Comments,
			'areas' => $areas, 
			'tasks' => $tasks, 
			'users' => $users,
			'auth_user' => $auth_user,
			'followers' => $followers,
			'follow' => $follow,
			'new_comment' => $new_comment,
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
		$validatedData = $request->validated();
		$validatedData['vip'] = $request->has('vip');
		Issue::whereId($issue->id)->update($validatedData);
        if ($request->has('save')) {
			return redirect('/issues/'.$issue->id);
		}
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
	
	public function reopen($id)
	{
		$issue = Issue::find($id);
		Issue::whereId($id)->update(['timeClosed' => null]);
		event(new IssueReopened($issue));
		event(new NewIssueComment($issue));
		return redirect()->back();
	}
	
}
