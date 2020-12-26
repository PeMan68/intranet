<?php

namespace App\Listeners\Issues;

use App\Events\Issues\UpdatedIssue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Issue;
use App\Jobs\Issues\SendEmailToFollowersAboutUpdate;

class NotifyFollowersOfUpdate
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
		$issue = Issue::find($event->issue->id);
		// Mail to all followers
		$followers = $issue->followers;
		foreach ($followers as $user) {
			SendEmailToFollowersAboutUpdate::dispatch($issue, $user->email);
		}
    }
}
