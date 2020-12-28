<?php

namespace App\Listeners\Issues;

use App\Events\Issues\NewIssue;
use Illuminate\Queue\InteractsWithQueue;
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
		foreach ($event->issue->task->users as $user) {
			if ($user->pivot->level == 3) {
                $event->issue->followers()->syncWithoutDetaching($user->id);
            }
        }

		$followers = $event->issue->followers;
        if ($event->urgent) {
            $delayReminder = now()->addMinutes(setting('time_reminder_urgent_issue'));
        } else {
            $delayReminder = now()->addHours($event->issue->task->priority->hours);
        }
        $delay=0;
        if (cache($event->issue->ticketNumber)) {
            $delay = now()->addMinutes(setting('time_disable_update_job'));
        }
        foreach ($followers as $user) {
            SendEmailAboutNewIssue::dispatch($event->issue, $user->email, $event->urgent)->delay($delay);
			SendEmailAboutReminder::dispatch($event->issue, $user->email, $event->urgent)->delay($delayReminder);
        }
    }
}
