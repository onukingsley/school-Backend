<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalaryPayment>
 */
class SalaryPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'staff_id' => $this->faker->numberBetween(1,28),
            'dues_id' => $this->faker->numberBetween(1,5),
            'transaction_type' => $this->faker->randomElement(['schoolFees','PTSA','HostelFees']),
            'amount' => $this->faker->numberBetween(1,5),
            'transaction_id' => $this->faker->uuid,
            'name' => $this->faker->name,


        ];
    }
}
