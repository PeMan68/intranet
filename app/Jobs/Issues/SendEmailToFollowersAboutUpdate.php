<?php

namespace App\Jobs\Issues;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Issue;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailToFollowersAboutUpdate;
use Illuminate\Support\Facades\Log;

class SendEmailToFollowersAboutUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
	public $retryAfter = 60;
	private $issue;
    private $email;
    private $type;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, $email, $type)
    {
        $this->issue = $issue;
        $this->email = $email;
        $this->type = $type; 
		$this->queue = 'emails';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       Mail::to($this->email)->send(new MailToFollowersAboutUpdate($this->issue, $this->type));
       Log::info('   MailToFollowersAboutUpdate skickas: '.$this->email);
    }
}
