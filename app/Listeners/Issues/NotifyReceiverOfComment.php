<?php

namespace App\Listeners\Issues;

use App\Events\Issues\IssuecommentOutboundMail;
use App\Jobs\Issues\SendEmailToReceiver;
use Illuminate\Support\Facades\Log;

class NotifyReceiverOfComment
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
     * @param  IssuecommentOutboundMail  $event
     * @return void
     */
    public function handle(IssuecommentOutboundMail $event)
    {
        SendEmailToReceiver::dispatch($event->issue, $event->receiver, $event->message);
    }
}
