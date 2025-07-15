<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ran2 =$this->faker->numberBetween(1,90);
        if (strlen($ran2)  == 1){
            $ran2 = '0'.$ran2;
        }
        return [
            'student_id' => $this->faker->numberBetween(2,90),
            'class_type_id' => $this->faker->numberBetween(1,8),
            'attendance' => $this->faker->boolean(80),
            'academic_session_id' => $this->faker->numberBetween(1,10),
            'term_id' => $this->faker->numberBetween(1,3)
        ];
    }
}
