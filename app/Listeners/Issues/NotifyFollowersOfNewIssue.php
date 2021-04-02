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
        if (cache($event->issue->ticketNumber)) {
            $delayMail = nextWorkingDateTime(setting('time_disable_update_job'));
        } else {
            $delayMail = nextWorkingDateTime();
        }
        
        add_followers($event, 3);

        $followers = $event->issue->followers;


        foreach ($followers as $user) {
            SendEmailAboutNewIssue::dispatch($event->issue, $user->email, $event->urgent)->delay($delayMail);
        }

        if ($event->urgent) {
            $minutes = setting('time_reminder_urgent_issue');
        } else {
            $minutes = $event->issue->task->priority->hours * 60;
        }
        $delayReminder = nextWorkingDateTime($minutes);

        // Reminder to contact customer
        CreateNewReminder::dispatch($event->issue, 'customerNotContacted', $event->urgent)->delay($delayReminder);

        // General reminder for issues without comments
        CreateNewReminder::dispatch($event->issue, null)->delay($delayReminder);
    }
}
