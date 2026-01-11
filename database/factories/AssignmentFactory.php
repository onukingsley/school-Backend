<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_id' => $this->faker->numberBetween(2,19),
            'class_type_id' => $this->faker->numberBetween(1,10),
            'title' => $this->faker->title,
            'content' => $this->faker->paragraph(2),
            'due_date' => $this->faker->dateTime,
            'term_id' => $this->faker->numberBetween(1,3),
            'academic_session_id' => $this->faker->numberBetween(1,10),
            'assignment_status' => $this->faker->randomElement(['assignment1','assignment2']),
        ];
    }
}
