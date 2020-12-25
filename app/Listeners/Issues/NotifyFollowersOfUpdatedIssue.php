<?php

namespace App\Listeners\Issues;

use App\Events\Issues\NewIssue;
use Illuminate\Queue\InteractsWithQueue;
use App\Task;
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
		$task = Task::find($taskID);
		$followers = $event->issue->followers;
        if ($event->urgent) {
            $delayhours = now()->addMinutes(30);
        } else {
            $delayhours = now()->addHours($task->priority->hours);
        }
        foreach ($followers as $user) {
            SendEmailAboutNewIssue::dispatch($event->issue, $user->email, $event->urgent);
			SendEmailAboutReminder::dispatch($event->issue, $user->email, $event->urgent)->delay($delayhours);
        }
    }
}
