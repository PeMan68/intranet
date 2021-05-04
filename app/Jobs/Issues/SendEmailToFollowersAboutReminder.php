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
use Illuminate\Support\Facades\Log;

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
                $delayDays = setting('days_reminder_paused_issue');
                break;
            case 'waitingForInternal':
                if (!$this->issue->waitingForInternal) {
                    return null;
                }
                $delayDays = setting('days_reminder_waiting_for_internal');
                break;
            case 'waitingForCustomer':
                if (!$this->issue->waitingForCustomer) {
                    return null;
                }
                $delayDays = setting('days_reminder_waiting_for_external');
                break;

            default:
                if ($this->issue->paused) {
                    return null;
                }
                if ($this->issue->waitingForInternal) {
                    return null;
                }
                if ($this->issue->waitingForCustomer) {
                    return null;
                }
                $delayDays = setting('days_reminder_waiting_for_comment');
                $delayDateTime = nextWorkingDateTime(workDaysToMinutes($delayDays));
                if (cache($this->issue->ticketNumber . 'Cold')) {
                    return null;
                }
                if (is_null($this->issue->latestComment)) {
                } else {
                    if (nextWorkingDateTime(workDaysToMinutes($delayDays) - 1, $this->issue->latestComment->updated_at) > nextWorkingDateTime()) {
                        return null;
                    }
                }
                cache([$this->issue->ticketNumber . 'Cold' => true], $delayDateTime);
                break;
        }
        Mail::to($this->email)->send(new MailToFollowersAboutReminder($this->issue, $this->typeOfReminder));
    }
}
