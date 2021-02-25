<?php

namespace App\Mail;

use App\Issue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailToFollowersAboutReminder extends Mailable
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
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type == 'paused'){
            $subject = ' Påminnelse, ärendet är pausat.';
        } elseif ($this->type == null) {
            $subject = ' Påminnelse, ärendet börjar bli kallt.';
        } else {
            $subject = ' Påminnelse, väntar på svar.';
        }
        return $this->subject($this->ticketNumber . ': ' . $this->header . $subject )
            ->view('emails.toFollowersAboutReminder');
    }
}
