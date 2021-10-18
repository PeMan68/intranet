<?php

namespace App\Mail;

use App\Issue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class MailToReceiverWithLatestComment extends Mailable
{
    use Queueable, SerializesModels;

    public $issue;
    public $mailMessage;
    /**
     * Create a new mailMessage instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, $mailMessage)
    {
        $this->issue = $issue;
        $this->mailMessage = $mailMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::debug('Mail is built');
        return $this->subject($this->issue->ticketNumber.': '.$this->issue->header)
        ->view('emails.toReceiverWithLatestComment');
    }
}
