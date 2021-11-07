<?php

namespace App\Listeners\Issues;

use App\Events\Issues\IssuePaused;
use App\Jobs\Issues\CreateNewReminder;
use App\Jobs\Issues\SendEmailToFollowersAboutReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

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
        $delayDateTime = nextWorkingDateTime(workDaysToMinutes(setting('days_reminder_paused_issue')));

        // Only if cache-key doesn't exist:
        // - Activate cache-key
        if (!cache($event->issue->ticketNumber . '-BlockPauseReminder')) {
            cache([$event->issue->ticketNumber . '-BlockPauseReminder' => true], $delayDateTime->subSeconds(1));
            // Log::info('Cache-key updated from NotifyFollowersOfPaused: ' . $event->issue->ticketNumber . '-BlockPauseReminder' . '. Expires: ' . $delayDateTime->subSeconds(1));
        }

        SendEmailToFollowersAboutReminder::dispatch($event->issue, $event->typeOfReminder)->delay($delayDateTime);
        // Log::info('Job SendEmailToFollowersAboutReminder dispathed: ' . $event->issue->ticketNumber . '. typeOfReminder: ' . $event->typeOfReminder . '. Delay: ' . $delayDateTime);
        CreateNewReminder::dispatch($event->issue, $event->typeOfReminder)->delay($delayDateTime);
        // Log::info('Dispatched new job: CreateNewReminder, ' . $event->issue->ticketNumber . '. typeOfReminder: ' . $event->typeOfReminder . '. Delay: ' . $delayDateTime);
    }
}
