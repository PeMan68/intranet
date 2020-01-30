<?php

namespace App\Listeners;

use App\Events\NewIssueComment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Issue;
use App\IssueComment;
use Illuminate\Support\Facades\Mail;
use App\Mail\IssueCommentedStaff;

class SendEmailToSubscribers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewIssueComment  $event
     * @return void
     */
    public function handle(NewIssueComment $event)
    {
		$issueID = $event->issuecomment->issue_id;
		$issue = Issue::find($issueID);
		// Mail to all followers
		//Nedan linje funkar, behöver filtrera ut följare
		//Mail::to('comment@comment.com')->send(new issueCommentedStaff($issue));
    }
}
