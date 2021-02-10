<?php

namespace App\Jobs\Issues;

use App\Events\Issues\IssuePaused;
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
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, $typeOfReminder)
    {
        $this->issue = $issue;
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
    }
}
