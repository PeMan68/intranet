<?php

namespace App\Listeners\Issues;

use App\Events\Issues\IssueWaitingForCustomer;
use App\Jobs\Issues\CreateNewReminder;
use App\Jobs\Issues\SendEmailToFollowersAboutReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NotifyFollowersOfExternal
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
    public function handle(IssueWaitingForCustomer $event)
    {
        $delayDateTime = nextWorkingDateTime(workDaysToMinutes(setting('days_reminder_waiting_for_external')));

        // Only if cache-key doesn't exist:
        // - Activate cache-key
        if (!cache($event->issue->ticketNumber . '-BlockCustomerReminder')) {
            cache([$event->issue->ticketNumber . '-BlockCustomerReminder' => true], $delayDateTime->subSeconds(1));
            // Log::info('Cache-key updated from NotifyFollowersOfInternal: ' . $event->issue->ticketNumber . '-BlockCustomerReminder' . '. Expires: ' . $delayDateTime->subSeconds(1));
        }

        SendEmailToFollowersAboutReminder::dispatch($event->issue, $event->typeOfReminder)->delay($delayDateTime);
        // Log::info('Job SendEmailToFollowersAboutReminder dispatched: '. $event->issue->ticketNumber . '. typeOfReminder: ' . $event->typeOfReminder .'. Delay: ' . $delayDateTime);
        CreateNewReminder::dispatch($event->issue, $event->typeOfReminder)->delay($delayDateTime);
        // Log::info('Dispatched new job: CreateNewReminder, '. $event->issue->ticketNumber . '. typeOfReminder: ' . $event->typeOfReminder .'. Delay: ' . $delayDateTime);
    }
}
