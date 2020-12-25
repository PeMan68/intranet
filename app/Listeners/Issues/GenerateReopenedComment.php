<?php

namespace App\Listeners\Issues;

use App\Events\Issues\IssueReopened;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use App\IssueComment;

class GenerateReopenedComment
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
		$new_comment = new IssueComment;
		$new_comment->issue_id = $event->issue->id;
		$new_comment->user_id = Auth::id();
		$new_comment->comment_internal = 'Ärendet öppnat igen';
		$new_comment->checkout = date('Y-m-d H:i',strtotime(now()));
		$new_comment->checkin = date('Y-m-d H:i',strtotime(now()));
		$new_comment->Save();
    }
}
