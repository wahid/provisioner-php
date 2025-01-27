<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\ProvisionedUser;
use App\Models\Group;
use App\Models\MemberFunction;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Types\EntityType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provisioned_user_id' => ProvisionedUser::factory(),
            'group_id' => Group::factory()->withMailbox(),
            'member_function_id' => MemberFunction::factory(),
            'employment_number' => $this->faker->unique()->numerify('EMP-#####'),
            'role' => $this->faker->jobTitle,
            'subscription' => $this->faker->word,
            'start_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'end_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'should_be_synced' => $this->faker->boolean,
            'should_calendar_be_enabled' => $this->faker->boolean,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'entity_type' => $this->faker->randomElement(array_column(EntityType::cases(), 'value')),
        ];
    }
}
