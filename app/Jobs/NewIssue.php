<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Issue;
use App\Task;
use Illuminate\Support\Facades\Mail;
use App\Mail\IssueCreated;


class NewIssue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	public $tries = 3;
	private $issue;
	private $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, $email)
    {
        $this->issue = $issue;
		$this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		if (is_null($this->issue->timeCustomercallback)) {
			Mail::to($this->email)->send(new issueCreated($this->issue));
		}
    }
}
