<?php

namespace App\Listeners\Issues;

use App\Events\IssueOpenedFirstTime;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Issue;
use App\IssueComment;
use Illuminate\Support\Facades\Mail;
use App\Mail\IssueOpened;
use Illuminate\Support\Facades\Auth;

class NotifyCreator
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
     * @param  IssueOpenedFirstTime $event
     * @return void
     */
    public function handle(IssueOpenedFirstTime $event)
    {
		//$issueID = $event->issuecomment->issue_id;
		$issue = Issue::find($event->issue->id);
		$user = User::find($issue->userCreate_id);
		Mail::to($user->email)->send(new issueOpened($issue));
    }
}
