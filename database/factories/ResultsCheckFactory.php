<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResultsCheck>
 */
class ResultsCheckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $staus = ['expired','valid'];
        return [
            'dues_id' => 1,
            'token' => $this->faker->uuid,
            'number_of_attempts' => $this->faker->numberBetween(0,5),
            'status' => $staus[$this->faker->numberBetween(0,1)],

        ];
    }
}
