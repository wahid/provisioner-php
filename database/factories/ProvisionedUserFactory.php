<?php

namespace Database\Factories;

use App\Models\ProvisionedUser;
use App\Types\UserActivationType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProvisionedUser>
 */
class ProvisionedUserFactory extends Factory
{
    protected $model = ProvisionedUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->unique()->uuid,
            'full_user_id' => $this->faker->uuid,
            'person_id' => $this->faker->uuid,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->firstName,
            'last_name' => $this->faker->lastName,
            'upn' => $this->faker->unique()->userName,
            'external_email' => $this->faker->unique()->safeEmail,
            'employment_start_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'employment_end_date' => $this->faker->optional()->dateTimeBetween('now', '+5 years'),
            'big_number' => $this->faker->optional()->numerify('BIG-#####'),
            'agb_code' => $this->faker->optional()->numerify('AGB-#####'),
            'employer_code' => $this->faker->optional()->numerify('EMP-#####'),
            'is_non_salaried' => $this->faker->boolean,
            'private_number' => $this->faker->optional()->phoneNumber,
            'private_email' => $this->faker->optional()->safeEmail,
            'email' => $this->faker->optional()->safeEmail,
            'reserved_email' => $this->faker->optional()->safeEmail,
            'should_have_license' => $this->faker->boolean,
            'should_be_synced' => $this->faker->boolean,
            'needs_signature_update' => $this->faker->boolean,
            'is_licensed' => $this->faker->boolean,
            'is_blocked' => $this->faker->boolean,
            'is_custom' => $this->faker->boolean,
            'should_include_in_global_address_list' => $this->faker->boolean,
            'account_activation_policy' => $this->faker->randomElement(array_column(UserActivationType::cases(), 'value')),
            'should_ignore_contracts' => $this->faker->boolean,
            'should_sync_back_to_data_provider' => $this->faker->boolean,
            'members_updated_at' => $this->faker->optional()->dateTime,
        ];
    }
}
