<?php

namespace App\Listeners\Issues;

use App\Events\Issues\IssueClosed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use App\IssueComment;

class GenerateClosedComment
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
		$new_comment = new IssueComment;
		$new_comment->issue_id = $event->issue->id;
		$new_comment->user_id = Auth::id();
		$new_comment->comment = 'Ärendet avslutat';
		$new_comment->checkout = date('Y-m-d H:i',strtotime(now()));
		$new_comment->checkin = date('Y-m-d H:i',strtotime(now()));
		$new_comment->Save();
		
    }
}
