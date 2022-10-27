<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'purchase_date' => fake()->date,
            'invoice_no' => fake()->date('ymd'),
            'supplier_id' => fake()->randomElement([1, 2, 3, 4]),
            'total' => fake()->randomFloat(0, 5000, 50000),
            'amount' => fake()->randomFloat(0, 5000, 50000),
            'is_paid' => true,
            'payment_type_id' => 1,
            'created_user_id' => 1
        ];
    }
}
