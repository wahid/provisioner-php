<?php

namespace App\Event;

use App\Plugins\Event;
use RabbitEvents\Publisher\ShouldPublish;
use RabbitEvents\Publisher\Support\Publishable;
use App\Models\Member;

class MemberEvent implements ShouldPublish
{
    use Publishable;

    public function __construct(
        public Event $event,
        public bool $successful,
        public Member $member,
        public string $message,
        public ?string $plugin,
    ) {
    }

    public function publishEventKey(): string
    {
        return $this->event->value . '.' . ($this->successful ? 'success' : 'failed');
    }

    public function toPublish(): mixed
    {
        return [
            'member_id' => $this->member->id,
            'message' => $this->message,
            'plugin' => $this->plugin
        ];
    }
}