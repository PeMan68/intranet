<?php

namespace App\Listeners\Issues;

use App\Events\Issues\NewIssue;
use App\Events\Issues\UpdatedIssue;
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

    // /**
    //  * Handle New Issue event.
    //  *
    //  * @param  NewIssue  $event
    //  * @return void
    //  */
    // public function handleNewIssue(NewIssue $event)
    // {
    //     $taskID = $event->issue->task_id;
	// 	$task = Task::find($taskID);
        
	// 	foreach ($task->users as $user) {
	// 		if ($user->pivot->level == 3) {
    //             $event->issue->followers()->syncWithoutDetaching($user->id);
    //         }
    //     }
    // }
    
    /**
     * Handle Updated Issue event.
     *
     * @param  UpdatedIssue  $event
     * @return void
     */
    public function handleUpdatedIssue(UpdatedIssue $event)
    // {
    //     $taskID = $event->issue->task_id;
	// 	$task = Task::find($taskID);
        
	// 	foreach ($task->users as $user) {
	// 		if ($user->pivot->level == 3) {
    //             $event->issue->followers()->syncWithoutDetaching($user->id);
    //         }
    //     }
    }

    public function subscribe($events) 
    {
        // $events->listen(
        //     'App\Events\Issues\NewIssue',
        //     'App\Listeners\Issues\AddFollowers@handleNewIssue'  
        // );
        // $events->listen(
        //     'App\Events\Issues\UpdatedIssue',
        //     'App\Listeners\Issues\AddFollowers@handleUpdatedIssue'  
        // );
    }
}
