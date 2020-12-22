<?php

namespace App\Listeners;

use App\Events\IssueNew;
use Illuminate\Queue\InteractsWithQueue;
use App\Task;
use App\Issue;
use App\Jobs\IssueNew as NewMail;
use App\Jobs\IssueReminder;

class IssueSendEmailToFollowers
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
        $taskID = $event->issue->task_id;
		$issueID = $event->issue->id;
		$task = Task::find($taskID);
        $issue = Issue::find($issueID);
        
		// Mail to all followers
		$followers = $issue->followers;
        if ($event->urgent) {
            $delayhours = now()->addMinutes(30);
        } else {
            $delayhours = now()->addHours($task->priority->hours);
        }
        foreach ($followers as $user) {
            NewMail::dispatch($issue, $user->email, $event->urgent);
			IssueReminder::dispatch($issue, $user->email, $event->urgent)->delay($delayhours);
        }
    }
}
