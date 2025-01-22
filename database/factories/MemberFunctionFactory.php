<?php

namespace Database\Factories;

use App\Models\MemberFunction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberFunction>
 */
class MemberFunctionFactory extends Factory
{
    protected $model = MemberFunction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle,
            'code' => $this->faker->unique()->bothify('FUNC-####'),
        ];
    }
}
