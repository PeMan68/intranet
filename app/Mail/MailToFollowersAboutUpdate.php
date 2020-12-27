<?php

namespace App\Mail;

use App\Issue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailToFollowersAboutUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The issue instance.
     *
     * @var Issue
     */
    public $issue;
    public $type;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, $type)
    {
        $this->issue = $issue;
		$this->ticketNumber = $issue->ticketNumber;
		$this->customer = $issue->customer;
        $this->header = $issue->header;
        $this->type= $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->ticketNumber.' Ny uppdatering i ärende: "'.$this->header.'"')
					->view('emails.toFollowersAboutUpdatedIssue');
    }
}
