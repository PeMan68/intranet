<?php

namespace App\Http\Controllers;

use App\IssueComment;
use App\Issue;
use Illuminate\Http\Request;
use App\Events\NewIssueComment;
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
		IssueComment::find($issuecomment->id)->update([
			'checkin' => date('Y-m-d H:i',strtotime(now())),
			'comment_internal' => $request->comment_internal,
			'comment_external' => $request->comment_external,
		]);
		//Send mail to staff who is following
		event(new NewIssueComment($issuecomment));
		//Add commenter as follower if not already
		if (!$request->follow) {
			$issue = Issue::find($issuecomment->issue_id);
			$issue->followers()->attach(Auth::id());
		}
        if ($request->has('saveAndClose')) {
			$validatedData['timeClosed'] = date('Y-m-d H:i:s');
			Issue::whereId($issuecomment->issue_id)->update([
			'timeClosed' => date('Y-m-d H:i')
			]);
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
