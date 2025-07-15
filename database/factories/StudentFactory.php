<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'guardian_id' => $this->faker->numberBetween(1,30),
            'class_type_id' => $this->faker->numberBetween(1,8),
            'role' => $this->faker->randomElement(['junior','senior','prefect']),
            'academic_average' => $this->faker->randomFloat(2,10,100),
            'academic_session_id' => $this->faker->numberBetween(1,10),

        ];
    }
}
