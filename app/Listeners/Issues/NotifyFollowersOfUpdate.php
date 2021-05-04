<?php

namespace App\Listeners\Issues;

use App\Events\Issues\UpdatedIssue;
use App\Jobs\Issues\CreateNewReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\Issues\SendEmailToFollowersAboutUpdate;
use Illuminate\Support\Facades\Log;

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
        add_followers($event, 3);
        
		// Prevent email if cache-key for this issue exist. 
        // It means a job will also include this update when it is run
        // All updates during Cache-time will be collected into one mail
        // instead of sending an email for every update.
		if (!cache($event->issue->ticketNumber)) {
			$followers = $event->issue->followers;
            $delay_email = nextWorkingDateTime(setting('minutes_to_collect_comments'));
            cache([$event->issue->ticketNumber => true], $delay_email);
			foreach ($followers as $user) {
				SendEmailToFollowersAboutUpdate::dispatch($event->issue, $user->email, $event->type)->delay($delay_email);
			}
            $delay = nextWorkingDateTime(workDaysToMinutes(setting('days_reminder_waiting_for_comment')));
            CreateNewReminder::dispatch($event->issue, null)->delay($delay);
		}
	}
}
