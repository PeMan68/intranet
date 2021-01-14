<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Issue;

class MailToCustomerAboutNewIssue extends Mailable
{
    use Queueable, SerializesModels;

    public $issue;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ärende '.$this->issue->ticketNumber)
                    ->view('emails.toCustomerAboutNewIssue');
    }
}
