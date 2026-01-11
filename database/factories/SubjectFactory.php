<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
           'description' => $this->faker->paragraph(1),
           'scheme_of_work' => $this->faker->paragraph(2),
            'title' => $this->faker->title,
            'class_list' => [
                $this->faker->numberBetween(0, 10),
                $this->faker->numberBetween(0, 10),
                $this->faker->numberBetween(0, 10),
            ],
            ];
    }
}
