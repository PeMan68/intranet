<?php

namespace App\Listeners\Issues;

use App\Events\Issues\NewIssue;
use App\Jobs\Issues\CreateNewReminder;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Issues\SendEmailAboutNewIssue;
class NotifyFollowersOfNewIssue
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
        
        add_followers($event, 3);

        $followers = $event->issue->followers;

        $delay = nextWorkingDateTime();
        if (cache($event->issue->ticketNumber)) {
            $delay = nextWorkingDateTime(setting('time_disable_update_job'));

        }
        foreach ($followers as $user) {
            SendEmailAboutNewIssue::dispatch($event->issue, $user->email, $event->urgent)->delay($delay);
        }

        if ($event->urgent) {
            $minutes = setting('time_reminder_urgent_issue');
        } else {
            $minutes = $event->issue->task->priority->hours * 60;
        }
        $delay = nextWorkingDateTime($minutes);

        // Reminder to contact customer
        CreateNewReminder::dispatch($event->issue, 'customerNotContacted', $event->urgent)->delay($delay);

        // General reminder for issues without comments
        CreateNewReminder::dispatch($event->issue, null)->delay($delay);
    }
}
