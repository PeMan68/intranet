<?php

namespace App\Http\Controllers;

use App\IssueComment;
use App\Issue;
use Illuminate\Http\Request;
use App\Events\Issues\UpdatedIssue;
use App\Events\Issues\IssueCommentedFirstTime;
use App\Events\Issues\IssueClosed;
use Illuminate\Support\Facades\Auth;

class IssueCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
	}

    // !Test store from axios
    public function storenew(Request $request)
    {
        $issuecomment = IssueComment::find($request->id);
        $issue = Issue::find($issuecomment->issue_id);
		if (!is_null($request->message))
		{
			IssueComment::find($issuecomment->id)->update([
				'checkin' => date('Y-m-d H:i:s',strtotime(now())),
                'comment' => $request->message,
                'contact_id' => $request->selected,
                'type' => $request->type,
                'direction' => $request->direction,
			]);
			//Send mail to creator if another user and this is first comment
			if ($issue->userCreate_id <> Auth::id())
			{
				if (IssueComment::where('issue_id', $issuecomment->issue_id)
					->count() == 1) 
				{
					event(new IssueCommentedFirstTime($issue));
				}
			}
			//Send mail to staff who is following
			//Add commenter as follower if not already
			if (!$request->follow) {
                $issue->followers()->attach(Auth::id());
			}
            event(new UpdatedIssue($issue, $type='comment',[]));
		}
        
        return redirect('/issues/'.$issuecomment->issue_id);
        return response()->json($issuecomment, 200);
		
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\IssueComment  $issueComment
     * @return \Illuminate\Http\Response
     */
    public function show(IssueComment $issueComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IssueComment  $issueComment
     * @return \Illuminate\Http\Response
     */
    public function edit(IssueComment $issueComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IssueComment  $issueComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IssueComment $issuecomment)
    {
		$issue = Issue::find($issuecomment->issue_id);
		if (!is_null($request->comment))
		{
			IssueComment::find($issuecomment->id)->update([
				'checkin' => date('Y-m-d H:i',strtotime(now())),
				'comment' => $request->comment,
			]);
			//Send mail to creator if another user and this is first comment
			if ($issue->userCreate_id <> Auth::id())
			{
				if (IssueComment::where('issue_id', $issuecomment->issue_id)
					->count() == 1) 
				{
					event(new IssueCommentedFirstTime($issue));
				}
			}
			//Send mail to staff who is following
			//Add commenter as follower if not already
			if (!$request->follow) {
                $issue->followers()->attach(Auth::id());
			}
            event(new UpdatedIssue($issue, $type='comment',[]));
		}
        if ($request->has('saveAndClose')) {
			$validatedData['timeClosed'] = date('Y-m-d H:i:s');
			Issue::whereId($issuecomment->issue_id)->update([
			'timeClosed' => date('Y-m-d H:i')
			]);
			event(new IssueClosed($issue));
			event(new UpdatedIssue($issue, $type='comment',[]));
			return redirect('/issues');
			
		}
		return redirect('/issues/'.$issuecomment->issue_id);
		
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IssueComment  $issueComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(IssueComment $issueComment)
    {
        //
    }
}
