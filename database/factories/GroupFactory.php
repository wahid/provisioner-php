<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Mailbox;
use App\Types\AccessType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'reserved_email' => $this->faker->unique()->safeEmail,
            'description' => $this->faker->sentence,
            'group_code' => $this->faker->unique()->bothify('GRP-####'),
            'is_created' => $this->faker->boolean,
            'is_custom' => $this->faker->boolean,
            'should_be_synced' => $this->faker->boolean,
            'mailbox_id' => null, // Assuming mailbox_id is nullable
            'should_have_mailbox' => $this->faker->boolean,
            'needs_update' => $this->faker->boolean,
            'needs_update_settings' => $this->faker->boolean,
            'access_policy' => $this->faker->randomElement(array_column(AccessType::cases(), 'value')),
        ];
    }

    public function withMailbox(): GroupFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'mailbox_id' => Mailbox::factory(),
            ];
        });
    }
}
