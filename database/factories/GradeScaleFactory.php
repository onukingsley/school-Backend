<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GradeScale>
 */
class GradeScaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grade' => $this->faker->randomElement(['A','B','C','D','E']),
            'min_score' => $this->faker->numberBetween(0,100),
            'max_score' => $this->faker->numberBetween(0,100),
            'remark' => $this->faker->paragraph(1),
        ];
    }
}
