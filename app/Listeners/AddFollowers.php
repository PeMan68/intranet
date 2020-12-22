<?php

namespace App\Listeners;

use App\Events\NewIssue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Task;

class AddFollowers
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
        
		foreach ($task->users as $user) {
			if ($user->pivot->level == 3) {
                $event->issue->followers()->attach($user->id);
            }
        }

    }
}
