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
    // private $email;
    private $typeOfReminder;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, $typeOfReminder)
    {
        $this->issue = $issue;
        // $this->email = $email;
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
        // Log::info('Handling Job: SendEmailToFollowersAboutReminder. ' . $this->issue->ticketNumber);
        if (!is_null($this->issue->timeClosed)) {
            return;
        }

        switch ($this->typeOfReminder) {
            case 'paused':
                if (!$this->issue->paused) {
                    // Log::info('   issue är inte Paused');
                    return null;
                }
                // Log::info('   BlockPauseReminder: ' . cache($this->issue->ticketNumber . '-BlockPauseReminder'));
                if (cache($this->issue->ticketNumber . '-BlockPauseReminder')) {
                    // Mailing blocked by cache-key.
                    return null;
                }
                break;

            case 'waitingForInternal':
                if (!$this->issue->waitingForInternal) {
                    // Log::info('   typeOfReminder är inte Internal');
                    return null;
                }
                if (cache($this->issue->ticketNumber . '-BlockInternalReminder')) {
                    // Mailing blocked by cache-key.
                    // Log::info('   MailToFollowersAboutReminder blockeras av BlockInternalReminder-key');
                    return null;
                }
                break;

            case 'waitingForCustomer':
                if (!$this->issue->waitingForCustomer) {
                    // Log::info('   typeOfReminder är inte Customer');
                    return null;
                }
                if (cache($this->issue->ticketNumber . '-BlockCustomerReminder')) {
                    // Mailing blocked by cache-key.
                    // Log::info('   MailToFollowersAboutReminder blockeras av BlockCustomerReminder-key');
                    return null;
                }
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
                if (cache($this->issue->ticketNumber . 'Cold')) {
                    // Mailing blocked by cahe-key.
                    return null;
                }
                break;
        }
        add_followers($this->issue, 3);
        $followers = $this->issue->followers;
        foreach ($followers as $follower) {
            Mail::to($follower->email)->send(new MailToFollowersAboutReminder($this->issue, $this->typeOfReminder));
            // Log::info('   MailToFollowersAboutReminder skickas: ' . $follower->email);
        }
    }
}
