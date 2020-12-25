<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Issue;
use Illuminate\Support\Facades\Mail;
use App\Mail\IssueCreated;


class IssueNew implements ShouldQueue
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
		Mail::to($this->email)->send(new issueCreated($this->issue, $this->urgent));
    }
}
