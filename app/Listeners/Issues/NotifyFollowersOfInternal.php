<?php

namespace App\Listeners\Issues;

use App\Events\Issues\IssueWaitingForInternal;
use App\Jobs\Issues\CreateNewReminder;
use App\Jobs\Issues\SendEmailToFollowersAboutReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyFollowersOfInternal
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
    public function handle(IssueWaitingForInternal $event)
    {
        // $delay = nextWorkingHour(now()->addDays(setting('days_reminder_waiting_for_internal')));
        $delay = now()->addMinutes(setting('days_reminder_waiting_for_internal'));
        $followers = $event->issue->followers;
        foreach ($followers as $follower) {
            SendEmailToFollowersAboutReminder::dispatch($event->issue, $follower->email, $event->typeOfReminder)->delay($delay);
        }
        CreateNewReminder::dispatch($event->issue, $event->typeOfReminder)->delay($delay);
    }
}
