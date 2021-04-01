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
        Log::info('Job: SendEmailToFollowersAboutReminder. ' . $this->issue->ticketNumber);
        if (!is_null($this->issue->timeClosed)) {
            Log::info(' - Avslutat. Inget mail skickat');
            return;
        }
        Log::info(' - typeOfReminder=' . $this->typeOfReminder);

        switch ($this->typeOfReminder) {
            case 'paused':
                if (!$this->issue->paused) {
                    Log::info('   ' . $this->typeOfReminder . ' inte aktuell längre. Inget mail skickat');
                    return null;
                }
                $delayDays = setting('days_reminder_paused_issue');
                break;
            case 'waitingForInternal':
                if (!$this->issue->waitingForInternal) {
                    Log::info('   ' . $this->typeOfReminder . ' inte aktuell längre. Inget mail skickat');
                    return null;
                }
                $delayDays = setting('days_reminder_waiting_for_internal');
                break;
            case 'waitingForCustomer':
                if (!$this->issue->waitingForCustomer) {
                    Log::info('   ' . $this->typeOfReminder . ' inte aktuell längre. Inget mail skickat');
                    return null;
                }
                $delayDays = setting('days_reminder_waiting_for_external');
                break;

            default:
                if ($this->issue->paused) {
                    Log::info('   Ärende markerat som pausat. Inget mail skickat');
                    return null;
                }
                if ($this->issue->waitingForInternal) {
                    Log::info('   Ärende markerat som väntar på kollega. Inget mail skickat');
                    return null;
                }
                if ($this->issue->waitingForCustomer) {
                    Log::info('   Ärende markerat som väntar på kund. Inget mail skickat');
                    return null;
                }
                $delayDays = setting('days_reminder_waiting_for_comment');
                $delayDateTime = nextWorkingDateTime(workDaysToMinutes($delayDays));
                if (cache($this->issue->ticketNumber . 'Cold')) {
                    Log::info('   Cache-key: ' . $this->issue->ticketNumber . 'Cold exist. Inget mail skickat');
                    return null;
                }
                if (is_null($this->issue->latestComment)) {
                    Log::info('   Finns ingen kommentar');
                } else {
                    if (nextWorkingDateTime(workDaysToMinutes($delayDays) - 1, $this->issue->latestComment->updated_at) > nextWorkingDateTime()) {
                        Log::info('   Senaste kommentar: ' . $this->issue->latestComment->updated_at);
                        Log::info('   Mail förväntas skickas: '.nextWorkingDateTime(workDaysToMinutes($delayDays), $this->issue->latestComment->updated_at));
                        Log::info('   Inget mail skickat');
                        return null;
                    }
                }
                break;
        }
        Mail::to($this->email)->send(new MailToFollowersAboutReminder($this->issue, $this->typeOfReminder));
        Log::info('   MailToFollowersAboutReminder skickas: '.$this->email);
    }
}
