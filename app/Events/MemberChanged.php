<?php

namespace App\Events;

use App\Models\Member;
use App\Types\ChangeEventType;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Member $member;

    public ChangeEventType $type;
    /**
     * Create a new event instance.
     */
    public function __construct(Member $member, ChangeEventType $type)
    {
        $this->member = $member;
        $this->type = $type;
    }
}
