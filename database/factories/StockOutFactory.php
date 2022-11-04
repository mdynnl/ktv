<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockOut>
 */
class StockOutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'stock_out_date' => fake()->date,
            'item_id' => fake()->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'qty' => fake()->randomDigitNotZero(),
            'price' => fake()->randomFloat(0, 2000, 20000),
            'stock_out_type_id' => fake()->randomElement([1, 2, 3, 4, 5]),
            'remark' => fake()->realText(30),
            'created_user_id' => 1,
        ];
    }
}
