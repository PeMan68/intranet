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
        $delay = nextWorkingDateTime(setting('days_reminder_waiting_for_internal') * (setting('stop_hour_workingday') - setting('start_hour_workingday')) * 60);
        $followers = $event->issue->followers;
        foreach ($followers as $follower) {
            SendEmailToFollowersAboutReminder::dispatch($event->issue, $follower->email, $event->typeOfReminder)->delay($delay);
            Log::info('SendEmailToFollowersAboutReminder dispatched: '. $event->issue->ticketNumber . ' to ' . $follower->email . '. typeOfReminder: ' . $event->typeOfReminder .'. Delay: ' . $delay);
        }
        CreateNewReminder::dispatch($event->issue, $event->typeOfReminder)->delay($delay);
        Log::info('Dispatched new job: CreateNewReminder, '. $event->issue->ticketNumber . '. typeOfReminder: ' . $event->typeOfReminder .'. Delay: ' . $delay);
    }
}
