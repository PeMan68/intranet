<?php

namespace App\Http\Controllers;

use App\IssueComment;
use Illuminate\Http\Request;

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
		
/* 		$comment = new IssueComment;
		$comment->issues = $request->issue_id;
		$comment->users = $request->user_id;
		$comment->comment_internal = $request->comment_internal;
		$comment->comment_external = $request->comment_external;
		$comment->checkout = now();
		$comment->Save();
		return redirect('/issues/'.$issue->id);
 */	
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
