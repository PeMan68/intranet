<?php

namespace App\Listeners\Issues;

use App\Events\Issues\IssueWaitingForComment;
use App\Jobs\Issues\CreateNewReminder;
use App\Jobs\Issues\SendEmailToFollowersAboutReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyFollowersOfComment
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
    public function handle(IssueWaitingForComment $event)
    {
        // $delay = nextWorkingHour(now()->addDays(setting('days_reminder_waiting_for_comment')));
        $delay = nextWorkingDateTime(setting('days_reminder_waiting_for_comment') * (setting('stop_hour_workday') - setting('start_hour_workday')) * 60);
        $followers = $event->issue->followers;
        foreach ($followers as $follower) {
            SendEmailToFollowersAboutReminder::dispatch($event->issue, $follower->email, null)->delay($delay);
        }
        CreateNewReminder::dispatch($event->issue, null)->delay($delay);
    }
}
