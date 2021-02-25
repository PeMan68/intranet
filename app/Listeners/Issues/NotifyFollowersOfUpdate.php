<?php

namespace App\Listeners\Issues;

use App\Events\Issues\UpdatedIssue;
use App\Jobs\Issues\CreateNewReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        // Sync so all with level === 3 are followers.
        // For example, task may have changed
		foreach ($event->issue->task->users as $user) {
			if ($user->pivot->level == 3) {
				$event->issue->followers()->syncWithoutDetaching($user->id);
			}
		}
		// Prevent email if cache-key is active	
		if (!cache($event->issue->ticketNumber)) {
			$followers = $event->issue->followers;
			foreach ($followers as $user) {
				SendEmailToFollowersAboutUpdate::dispatch($event->issue, $user->email, $event->type);
			}
            $delay = nextWorkingHour(now()->addDays(setting('days_reminder_waiting_for_comment')));
            CreateNewReminder::dispatch($event->issue, null)->delay($delay);
		}
	}
}
