<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'balance' => $this->faker->randomElement(['credit','debit']),
            'amount' => $this->faker->numberBetween(5000,500000),
            'description' => $this->faker->paragraph(1),
            'transaction_id' => $this->faker->uuid,
            'transaction_name' => $this->faker->title,
            'transaction_type' => $this->faker->title
        ];
    }
}
