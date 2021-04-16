<?php

namespace App\Listeners\Issues;

use App\Events\Issues\IssueWaitingForComment;
use App\Jobs\Issues\CreateNewReminder;
use App\Jobs\Issues\SendEmailToFollowersAboutReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

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
        $delayDateTime = nextWorkingDateTime(workDaysToMinutes(setting('days_reminder_waiting_for_comment')));
        cache([$event->issue->ticketNumber . 'Cold' => true], $delayDateTime->subSeconds(1));
        Log::info('Cache-key updated: ' . $event->issue->ticketNumber . 'Cold' . '. Expires: ' . $delayDateTime->subSeconds(1));
        // $followers = $event->issue->followers;
        // foreach ($followers as $follower) {
            SendEmailToFollowersAboutReminder::dispatch($event->issue, null)->delay($delayDateTime);
        // }
        CreateNewReminder::dispatch($event->issue, null)->delay($delayDateTime);
    }
}
