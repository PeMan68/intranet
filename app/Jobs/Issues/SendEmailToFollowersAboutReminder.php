<?php

namespace App\Jobs\Issues;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailToFollowersAboutReminder;
use App\Issue;

class SendEmailToFollowersAboutReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    public $retryAfter = 60;
    private $issue;
    private $email;
    private $typeOfReminder;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, $email, $typeOfReminder)
    {
        $this->issue = $issue;
        $this->email = $email;
        $this->typeOfReminder = $typeOfReminder;
        $this->queue = 'emails';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!is_null($this->issue->timeClosed)) {
            return;
        }

        switch ($this->typeOfReminder) {
            case 'paused':
                if (!$this->issue->paused) {
                    return null;
                }
                $delayDays=setting('days_reminder_paused_issue');
                break;
            case 'waitingForInternal':
                if (!$this->issue->waitingForInternal) {
                    return null;
                }
                $delayDays=setting('days_reminder_waiting_for_internal');
                break;
            case 'waitingForCustomer':
                if (!$this->issue->waitingForCustomer) {
                    return null;
                }
                $delayDays=setting('days_reminder_waiting_for_customer');
                break;
                
            default:
                $delayDays=setting('days_reminder_issue');
                break;
        }
        // if ($this->typeOfReminder == 'paused') {
        //     if (!$this->issue->paused) {
        //         return null;
        //     }
            // Has there been comments since the job was created, don't send mail, just add new reminder
            if ($this->issue->latestComment->updated_at->addDays($delayDays) > now()) {
                $delay = nextWorkingHour(now()->addDays($delayDays));
                CreateNewReminder::dispatch($this->issue, $this->typeOfReminder)->delay($delay);
                return null;
            }
        }
        // if ($this->typeOfReminder == 'waitingForInternal') {
        //     if (!$this->issue->waitingForInternal) {
        //         return null;
        //     }
        // }
        // if ($this->typeOfReminder == 'waitingForCustomer') {
        //     if (!$this->issue->waitingForCustomer) {
        //         return null;
        //     }
        // }
        Mail::to($this->email)->send(new MailToFollowersAboutReminder($this->issue, $this->typeOfReminder));
    }
}
