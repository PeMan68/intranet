<?php

namespace App\Listeners\Issues;

use App\Events\Issues\IssuePaused;
use App\Jobs\Issues\SendEmailToFollowersAboutReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyFollowersOfPaused
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
     * @param  object  $event
     * @return void
     */
    public function handle(IssuePaused $event)
    {
        $delay = nextWorkingHour(now()->addDays(setting('days_reminder_paused_issue')));
        $followers = $event->issue->followers;
        foreach ($followers as $follower) {
            SendEmailToFollowersAboutReminder::dispatch($event->issue, $follower->email, $event->typeOfReminder)->delay($delay);
        }
    }
}
