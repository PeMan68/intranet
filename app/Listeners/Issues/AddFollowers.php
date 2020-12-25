<?php

namespace App\Listeners\Issues;

use App\Events\Issues\NewIssue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddFollowers
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
        //
    }
}
