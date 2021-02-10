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

class IssueWaitingForInternal
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $typeOfReminder;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, $typeOfReminder)
    {
        $this->issue = $issue;
        $this->typeOfReminder = $typeOfReminder;
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
