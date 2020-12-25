<?php

namespace App\Listeners\Issues;

use App\Events\Issues\NewIssue;
use Illuminate\Queue\InteractsWithQueue;
use App\Task;
use App\Issue;
use App\Jobs\Issues\SendEmailAboutNewIssue;
use App\Jobs\Issues\SendEmailAboutReminder;

class NotifyFollowersOfUpdatedIssue
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
            SendEmailAboutNewIssue::dispatch($issue, $user->email, $event->urgent);
			SendEmailAboutReminder::dispatch($issue, $user->email, $event->urgent)->delay($delayhours);
        }
    }
}
