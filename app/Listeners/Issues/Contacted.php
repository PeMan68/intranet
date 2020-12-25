<?php

namespace App\Listeners\Issues;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Issue;

class Contacted
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
    public function handle($event)
    {
        $issueID = $event->issue->id;
        if (is_null(Issue::find($issueID)->timeCustomercallback)) {
            Issue::whereId($issueID)->update(['timeCustomercallback' => date('Y-m-d H:i',strtotime(now()))]);
        }
    }
}
