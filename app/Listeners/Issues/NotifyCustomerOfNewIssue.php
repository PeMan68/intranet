<?php

namespace App\Listeners\Issues;

use App\Events\Issues\NewIssue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\Issues\SendEmailToCustomerAboutNewIssue;

class NotifyCustomerOfNewIssue
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
        if (!is_null($event->issue->customerMail)) {
            $delay=0;
            if (cache($event->issue->ticketNumber)){
                $delay = now()->addMinutes(setting('time_disable_update_job'));
            }
            SendEmailToCustomerAboutNewIssue::dispatch($event->issue, $event->issue->customerMail)->delay($delay);
        }
    }
}
