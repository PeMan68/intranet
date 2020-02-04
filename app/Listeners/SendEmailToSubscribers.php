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
		$followers = $issue->followers;
		//Nedan linje funkar, behöver filtrera ut följare
		foreach ($followers as $user) {
			Mail::to($user->email)->send(new issueCommentedStaff($issue));
		}
    }
}
