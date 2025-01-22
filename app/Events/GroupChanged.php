<?php

namespace App\Events;

use App\Models\Group;
use App\Types\ChangeEventType;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Group $group;
    public ChangeEventType $type;

    /**
     * Create a new event instance.
     */
    public function __construct(Group $group, ChangeEventType $type)
    {
        $this->group = $group;
        $this->type = $type;
    }
}

