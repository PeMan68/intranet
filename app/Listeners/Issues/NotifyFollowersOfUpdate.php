<?php

namespace App\Listeners\Issues;

use App\Events\Issues\UpdatedIssue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Issue;
use App\Jobs\Issues\SendEmailToFollowersAboutUpdate;

class NotifyFollowersOfUpdate
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
     * @param  UpdatedIssue  $event
     * @return void
     */
    public function handle(UpdatedIssue $event)
    {
      foreach ($event->issue->task->users as $user) {
        if ($user->pivot->level == 3) {
                  $event->issue->followers()->syncWithoutDetaching($user->id);
              }
          }
		$issue = Issue::find($event->issue->id);
		if (!cache($event->issue->ticketNumber)) {
			$followers = $event->issue->followers;
			foreach ($followers as $user) {
				SendEmailToFollowersAboutUpdate::dispatch($event->issue, $user->email, $event->type);
			}
		}
	}
}
