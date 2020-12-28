<?php

namespace App\Listeners\Issues;

use App\Events\Issues\NewIssue;
use Illuminate\Queue\InteractsWithQueue;
use App\Task;
use App\Jobs\Issues\SendEmailAboutNewIssue;
use App\Jobs\Issues\SendEmailAboutReminder;

class NotifyFollowersOfNewIssue
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
        
		foreach ($task->users as $user) {
			if ($user->pivot->level == 3) {
                $event->issue->followers()->syncWithoutDetaching($user->id);
            }
        }

		$followers = $event->issue->followers;
        if ($event->urgent) {
            $delayhours = now()->addMinutes(30);
        } else {
            $delayhours = now()->addHours($task->priority->hours);
        }
        $delay=0;
        if (cache($event->issue->ticketNumber)) {
            $delay = now()->addMinutes(setting('time_disable_update_job'));
        }
        foreach ($followers as $user) {
            SendEmailAboutNewIssue::dispatch($event->issue, $user->email, $event->urgent)->delay($delay);
			SendEmailAboutReminder::dispatch($event->issue, $user->email, $event->urgent)->delay($delayhours);
        }
    }
}
