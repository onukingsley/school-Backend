<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guardian>
 */
class GuardianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'occupation' => $this->faker->jobTitle,
            'alt_phone_no' => $this->faker->phoneNumber,
            'office_address' => $this->faker->address(),
        ];
    }
}
