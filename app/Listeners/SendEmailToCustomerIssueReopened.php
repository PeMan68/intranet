<?php

namespace App\Listeners;

use App\Events\IssueReopened;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToCustomerIssueReopened
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
     * @param  IssueReopened  $event
     * @return void
     */
    public function handle(IssueReopened $event)
    {
        //
    }
}
