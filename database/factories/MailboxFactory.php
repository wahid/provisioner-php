<?php

namespace Database\Factories;

use App\Models\Mailbox;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mailbox>
 */
class MailboxFactory extends Factory
{
    protected $model = Mailbox::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'is_licensed' => $this->faker->boolean,
            'is_mailbox_delegated' => $this->faker->boolean,
            'is_calendar_delegated' => $this->faker->boolean,
            'is_calendar_named' => $this->faker->boolean,
            'is_created' => $this->faker->boolean,
            'is_grouped' => $this->faker->boolean,
            'is_send_alias_created' => $this->faker->boolean,
            'is_password_reset' => $this->faker->boolean,
        ];
    }
}
