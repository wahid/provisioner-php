<?php

namespace App\Events;

use App\Models\User;
use App\Types\ChangeEventType;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    public ChangeEventType $type;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, ChangeEventType $type)
    {
        $this->user = $user;
        $this->type = $type;
    }
}
