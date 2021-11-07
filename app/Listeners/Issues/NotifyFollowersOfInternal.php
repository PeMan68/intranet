<?php

namespace App\Listeners\Issues;

use App\Events\Issues\IssueWaitingForInternal;
use App\Jobs\Issues\CreateNewReminder;
use App\Jobs\Issues\SendEmailToFollowersAboutReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

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
        $delayDateTime = nextWorkingDateTime(workDaysToMinutes(setting('days_reminder_waiting_for_internal')));

        // Only if cache-key doesn't exist:
        // - Activate cache-key
        if (!cache($event->issue->ticketNumber . '-BlockInternalReminder')) {
            cache([$event->issue->ticketNumber . '-BlockInternalReminder' => true], $delayDateTime->subSeconds(1));
            // Log::info('Cache-key updated from NotifyFollowersOfInternal: ' . $event->issue->ticketNumber . '-BlockInternalReminder' . '. Expires: ' . $delayDateTime->subSeconds(1));
        }
            SendEmailToFollowersAboutReminder::dispatch($event->issue, $event->typeOfReminder)->delay($delayDateTime);
            // Log::info('Job SendEmailToFollowersAboutReminder dispatched: '. $event->issue->ticketNumber . '. typeOfReminder: ' . $event->typeOfReminder .'. Delay: ' . $delayDateTime);
        // }
        CreateNewReminder::dispatch($event->issue, $event->typeOfReminder)->delay($delayDateTime);
        // Log::info('Dispatched new job: CreateNewReminder, '. $event->issue->ticketNumber . '. typeOfReminder: ' . $event->typeOfReminder .'. Delay: ' . $delayDateTime);
    }
}
