<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Issue;

class MailToCustomerAboutUpdate extends Mailable
{
    use Queueable, SerializesModels;

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
					->view('emails.toCustomerAboutUpdatedIssue');
    }
}
