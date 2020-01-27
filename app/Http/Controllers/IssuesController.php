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

class IssuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		check_in_issues();
		
		// cleanup task_user table for current user
		$tasks = Task::all();
		Auth::user()->tasks()->sync($tasks);
		
		$filters = $request->search;
		if (isset($filters)) { 
		// list all issues matching $filter
		// 
		$issues = Issue::filter($filters)
					->get()
					;
			
		} else {
		// list open issues
		// sort by level, timeEstimated Callback
		$issues = Issue::filter($filters)
					->whereNull('timeClosed')
					->get()
					->sortBy('calculated_prio')
					;
		}
		return view('issues.index',compact('issues',$issues),['filter' => $filters]);
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
		$users = User::where('active', 1)->get();
		$initTime=date('Y-m-d H:i:s');

		return view('issues.create')->with(['areas' => $areas, 'tasks' => $tasks, 'users' => $users, 'timeInit' => $initTime]);
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
		$validatedData['timeEstimatedcallback'] = date('Y-m-d H:i', strtotime(sprintf("+%d hours", $hours)));
		$validatedData['vip'] = $request->has('vip');
		//build ticketnumber, S+year+number of issues currentyear.
		$validatedData['ticketNumber'] = 'S-' . date('y') . sprintf('%02d',Issue::whereYear('created_at', date('Y'))->count() +1);
        $issue = Issue::create($validatedData);
		Mail::to('per.manholm@gmail.com')->send(new issueCreated($issue));
        if ($request->has('save')) {
			return redirect('/issues');
		}
        if ($request->has('saveOpen')) {
			return redirect('/issues/'.$issue->id);
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
 		
		check_in_issues();
		$new_comment = check_out_issue($issue);
		
		return view('issues.show')->with([
			'issue' => $issue, 
			'comments' => $Comments,
			'areas' => $areas, 
			'tasks' => $tasks, 
			'users' => $users,
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
		//Validate
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
}
