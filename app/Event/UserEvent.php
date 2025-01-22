<?php

namespace App\Event;

use App\Plugins\Event;
use RabbitEvents\Publisher\ShouldPublish;
use RabbitEvents\Publisher\Support\Publishable;
use App\Models\User;

class UserEvent implements ShouldPublish
{
    use Publishable;

    public function __construct(
        public Event $event,
        public bool $successful,
        public User $user,
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
            'user_id' => $this->user->id,
            'message' => $this->message,
            'plugin' => $this->plugin
        ];
    }
}