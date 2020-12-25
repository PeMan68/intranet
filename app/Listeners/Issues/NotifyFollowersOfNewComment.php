<?php

namespace App\Listeners\Issues;

use App\Events\Issues\NewComment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Issue;
use App\Jobs\Issues\SendEmailAboutNewComment;

class NotifyFollowersOfNewComment
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
     * @param  NewComment  $event
     * @return void
     */
    public function handle(NewComment $event)
    {
		$issue = Issue::find($event->issue->id);
		// Mail to all followers
		$followers = $issue->followers;
		foreach ($followers as $user) {
			SendEmailAboutNewComment::dispatch($issue, $user->email);
		}
    }
}
