<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Issue;
use Illuminate\Support\Facades\Mail;
use App\Mail\IssueReminder;

class IssueReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
	public $retryAfter = 60;
	private $issue;
	private $email;
	private $urgent;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, $email, $urgent)
    {
        $this->issue = $issue;
		$this->email = $email;
		$this->urgent = $urgent;
		$this->queue = 'emails';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		if (!is_null($this->issue->timeCustomercallback)) {
			return;
		}
		Mail::to($this->email)->send(new issueReminder($this->issue, $this->urgent));

		// add to queue again as a reminder
        if ($this->urgent) {
            $delayhours = now()->addMinutes(30);
        } else {
            $delayhours = now()->addHours($task->priority->hours);
		}
		$this->release($delayhours);
    }

}
