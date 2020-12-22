<?php

namespace App\Listeners;

use App\Events\NewIssueComment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Issue;
use App\IssueComment;
use Illuminate\Support\Facades\Mail;
use App\Mail\IssueCommentedStaff;
use Illuminate\Support\Facades\Auth;

class IssueSendEmailToSubscribers
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
		$issue = Issue::find($event->issue->id);
		// Mail to all followers
		$followers = $issue->followers;
		foreach ($followers as $user) {
			if ($user->id <> Auth::id()) {
				Mail::to($user->email)->send(new issueCommentedStaff($issue));
			}
		}
    }
}
