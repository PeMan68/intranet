<?php

namespace App\Listeners;

use App\Events\NewIssue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Issue;
use App\User;
use App\Task;
use Illuminate\Support\Facades\Mail;
use App\Mail\IssueCreated;
use Illuminate\Support\Facades\Auth;

class SendEmailToResponsible
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
     * @param  NewIssue  $event
     * @return void
     */
    public function handle(NewIssue $event)
    {
        //
		$taskID = $event->issue->task_id;
		$issueID = $event->issue->id;
		$task = Task::find($taskID);
        $issue = Issue::find($issueID);
        
		foreach ($task->users as $user) {
			if ($user->pivot->level == 3){
				Mail::to($user->email)->send(new issueCreated($issue, $event->urgent));
			}
		}
    }
}
