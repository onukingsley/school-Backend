<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Class_type>
 */
class ClassTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subject_list = ['maths','english','physics','computer','Home Economics'];
        return [
            'class_name' => $this->faker->title,
            'number_of_students'=> $this->faker->numberBetween(20,50),
            'class_type_name' => $this->faker->randomElement(['junior','senior']),
            /*'subject' => [
                $subject_list[$this->faker->numberBetween(0, 4)],
                $subject_list[$this->faker->numberBetween(0, 4)],
                $subject_list[$this->faker->numberBetween(0, 4)],
            ],*/
            'subject' => [
                $this->faker->numberBetween(0, 19),
                $this->faker->numberBetween(0, 19),
                $this->faker->numberBetween(0, 19),
                $this->faker->numberBetween(0, 19),
                $this->faker->numberBetween(0, 19),
                $this->faker->numberBetween(0, 19),
                $this->faker->numberBetween(0, 19),
            ],
            'staff_id' => $this->faker->numberBetween(1,28)
        ];
    }
}
