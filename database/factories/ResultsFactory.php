<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Results>
 */
class ResultsFactory extends Factory
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
            'subject_id' => $this->faker->numberBetween(1,20),
            'class_type_id' => $this->faker->numberBetween(1,8),
            'term_id' => $this->faker->numberBetween(1,3),
            'academic_session_id' => $this->faker->numberBetween(1,10),
            'level' => $this->faker->randomElement(['junior','senior']),
            'grade_scale_id' => $this->faker->numberBetween(1,5),
            'test1' => $this->faker->numberBetween(1,10),
            'test2' => $this->faker->numberBetween(1,10),
            'assignment1' => $this->faker->numberBetween(1,10),
            'assignment2' => $this->faker->numberBetween(1,10),
            'total' => $this->faker->numberBetween(1,100),
            'exam' => $this->faker->numberBetween(1,60),

        ];
    }
}
