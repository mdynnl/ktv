<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'item_name' => fake()->name,
            'recipe_unit' => fake()->randomElement(['kg', 'litre', 'pound', 'gram']),
            'recipe_price' => fake()->randomFloat(0, 500, 5000),
            'reorder' => 50,
            'opening_qty' => 0,
            'current_qty' => 0,
            'is_kitchen_item' => fake()->boolean,
            'created_user_id' => 1
        ];
    }
}
