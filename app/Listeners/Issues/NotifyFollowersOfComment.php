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
        $delay = nextWorkingDateTime(workDaysToMinutes(setting('days_reminder_waiting_for_comment')));
        $followers = $event->issue->followers;
        foreach ($followers as $follower) {
            SendEmailToFollowersAboutReminder::dispatch($event->issue, $follower->email, null)->delay($delay);
        }
        CreateNewReminder::dispatch($event->issue, null)->delay($delay);
    }
}
