<?php

namespace App\Listeners;

use App\Events\IssueClosed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToResponsibleIssueClosed
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
     * @param  IssueClosed  $event
     * @return void
     */
    public function handle(IssueClosed $event)
    {
        //
    }
}
