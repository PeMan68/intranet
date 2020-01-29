<?php

namespace App\Mail;

use App\Issue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IssueCommentedStaff extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The issue instance.
     *
     * @var Issue
     */
	public $issue;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, IssueComment $comment)
    {
        $this->issue = $issue;
		$this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ny kommentar i ärende du föler')
					->view('emails.issueCommentedStaff');
    }
}
