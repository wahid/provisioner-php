<?php

namespace App\Event;

use App\Plugins\Event;
use RabbitEvents\Publisher\ShouldPublish;
use RabbitEvents\Publisher\Support\Publishable;
use App\Models\Group;

class GroupEvent implements ShouldPublish
{
    use Publishable;

    public function __construct(
        private Event $event,
        private bool $successful,
        private Group $group,
        private string $message,
        private ?string $plugin,
    ) {

    }

    public function publishEventKey(): string
    {
        return $this->event->value . '.' . ($this->successful ? 'success' : 'failed');
    }

    public function toPublish(): mixed
    {
        return [
            'group_id' => $this->group->id,
            'message' => $this->message,
            'plugin' => $this->plugin
        ];
    }
}