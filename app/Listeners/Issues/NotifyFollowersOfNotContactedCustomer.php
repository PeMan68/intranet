<?php

namespace App\Listeners\Issues;

use App\Events\Issues\CustomerNotContacted;
use App\Issue;
use App\Jobs\Issues\CreateNewReminder;
use App\Jobs\Issues\SendEmailAboutReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyFollowersOfNotContactedCustomer
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
    public function handle(CustomerNotContacted $event)
    {
        if (is_null($event->issue->timeCustomercallback)) {
            // Add both level 2 and 3 to followers to broaden the notification
            // level 2 followers can unfollow at anytime.

            add_followers($event, 2);
            add_followers($event, 3);
            
            $followers = $event->issue->followers;
            
            if ($event->urgent) {
                $minutes = setting('time_reminder_urgent_issue');
            } else {
                $minutes = $event->issue->task->priority->hours * 60;
            }
            $delay = nextWorkingDateTime($minutes);
            
            foreach ($followers as $user) {
                SendEmailAboutReminder::dispatch($event->issue, $user->email, $event->urgent)->delay($delay);
            }
            CreateNewReminder::dispatch($event->issue, 'customerNotContacted', $event->urgent)->delay($delay);
        } 
    }
}
