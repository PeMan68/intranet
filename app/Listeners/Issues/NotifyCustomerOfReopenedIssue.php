<?php

namespace App\Listeners\Issues;

use App\Events\Issues\IssueReopened;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCustomerOfReopenedIssue
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
