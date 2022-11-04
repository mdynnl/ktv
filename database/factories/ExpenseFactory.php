<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'expense_date' => fake()->date,
            'expense_type_id' => fake()->randomElement([1,2,3]),
            'description' => fake()->realText(20),
            'price' => fake()->randomFloat(0, 5000, 20000),
            'qty' => fake()->randomDigitNotZero(),
            'created_user_id' => 1,
        ];
    }
}
