<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker;
        return [
            'user_id' => User::factory(),
            'customer_id' => Customer::factory(),
            'total_amount' => $faker->randomFloat(2, 10, 1000),
            'payment_method' => $faker->randomElement(['Cash', 'Credit Card', 'Debit Card']),
        ];
    }
}
