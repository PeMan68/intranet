<?php

namespace App\Events\Issues;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Issue;
class NewIssue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param \App\Issue $issue
     * 
     * @param mixed $hours
     * 
     * @param mixed $delayJob
     * 
     * @return void
     */
    public function __construct(Issue $issue, $hours)
    {
        $this->issue = $issue;
        $this->urgent = false;
        if ($hours==0) {
            $this->urgent = true;
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
