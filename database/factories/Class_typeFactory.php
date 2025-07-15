<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Class_type>
 */
class Class_typeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_name' => $this->faker->title,
            'number_of_students'=> $this->faker->numberBetween(20,50),
            'class_type' => $this->faker->randomElement(['junior','senior']),
            'subject' => $this->faker->title,
            'staff_id' => $this->faker->numberBetween(1,28)
        ];
    }
}
