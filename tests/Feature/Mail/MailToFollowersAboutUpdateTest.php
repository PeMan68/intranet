<?php

namespace Tests\Feature\Mail;

use App\Issue;
use App\Mail\MailToFollowersAboutUpdate;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailToFollowersAboutUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_syntax_of_class()
    {
        $issue = factory(Issue::class)->create();

        $mail = new MailToFollowersAboutUpdate($issue,'');
        $response = $mail->build();
        
        $this->assertContains($issue->ticketNumber, $response->subject);
    }
}
