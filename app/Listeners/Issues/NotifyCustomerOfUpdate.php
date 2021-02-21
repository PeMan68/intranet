<?php

namespace App\Listeners\Issues;

use App\Events\Issues\UpdatedIssue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\Issues\SendEmailToCustomerAboutUpdate;
use Illuminate\Support\Arr;

class NotifyCustomerOfUpdate
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
     * @param  UpdatedIssue  $event
     * @return void
     */
    public function handle(UpdatedIssue $event)
    {
        $fieldsToNotify = [
            'customer',
            'customerNumber',
            'customerName',
            'customerTel',
            'customerMail',
            'description',
            'header',
        ];
        if (!empty(Arr::only($event->changedFields, $fieldsToNotify)) &&
            $event->type == 'header' &&
            !is_null($event->issue->customerMail) &&
            !cache($event->issue->ticketNumber)
        )

        {
            SendEmailToCustomerAboutUpdate::dispatch($event->issue, $event->issue->customerMail, $event->type);
        }
    }
}
