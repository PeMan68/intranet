<?php

namespace App\Mail;

use App\Issue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IssueReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $issue;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, $urgent)
    {
        $this->issue = $issue;
		$this->ticketNumber = $issue->ticketNumber;
        $this->customer = $issue->customer;
        $this->header = $issue->header;
        $this->urgent = ' ';
        if ($urgent) {
            $this->urgent = ' BRÅDSKANDE! ';
        }

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->ticketNumber.$this->urgent.$this->header.' Påminnelse, kunden har inte blivit kontaktad ännu!')
                    ->view('emails.issueCreated');
    }
}
