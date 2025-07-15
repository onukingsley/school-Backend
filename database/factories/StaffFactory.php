<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone_no' => $this->faker->phoneNumber,
            'account_no' => $this->faker->uuid,
            'form_teacher' => $this->faker->boolean,
            'subject' => $this->faker->titleMale,
            'staff_role_id' => $this->faker->numberBetween(1,5),
            'dues_id' => $this->faker->numberBetween(1,5),

        ];
    }
}
