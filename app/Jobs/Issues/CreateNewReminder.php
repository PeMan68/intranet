<?php

namespace App\Jobs\Issues;

use App\Events\Issues\CustomerNotContacted;
use App\Events\Issues\IssuePaused;
use App\Events\Issues\IssueWaitingForComment;
use App\Events\Issues\IssueWaitingForCustomer;
use App\Events\Issues\IssueWaitingForInternal;
use App\Issue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateNewReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $issue;
    private $typeOfReminder;
    private $urgent;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, $typeOfReminder, $urgent = false)
    {
        $this->issue = $issue;
        $this->typeOfReminder = $typeOfReminder;
        $this->queue = 'emails';
        $this->urgent = $urgent;
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
        if ($this->typeOfReminder == 'paused') {
            if ($this->issue->paused) {
                event(new IssuePaused($this->issue, 'paused'));
            }
        }
        if ($this->typeOfReminder == 'waitingForInternal') {
            if ($this->issue->waitingForInternal) {
                event(new IssueWaitingForInternal($this->issue, 'waitingForInternal'));
            }
        }
        if ($this->typeOfReminder == 'waitingForCustomer') {
            if ($this->issue->waitingForCustomer) {
                event(new IssueWaitingForCustomer($this->issue, 'waitingForCustomer'));
            }
        }
        if ($this->typeOfReminder == 'customerNotContacted') {
            if (is_null($this->issue->timeCustomercallback)) {
                event(new CustomerNotContacted($this->issue, $this->urgent));
            }
        }
        if ($this->typeOfReminder == null) {
                event(new IssueWaitingForComment($this->issue, null));
        }
    }
}
