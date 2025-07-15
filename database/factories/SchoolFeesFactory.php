<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchoolFees>
 */
class SchoolFeesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => $this->faker->numberBetween(2,90),
            'dues_id' => $this->faker->numberBetween(1,5),
            'amount' => $this->faker->numberBetween(30000,330000),
            'name' => $this->faker->title,
            'academic_session_id' => $this->faker->numberBetween(1,10),
            'term_id' => $this->faker->numberBetween(1,3),
            'transaction_id' => $this->faker->uuid,
            'transaction_type' => $this->faker->title

        ];
    }
}
