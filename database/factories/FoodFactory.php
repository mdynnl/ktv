<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'food_name' => $this->faker->words(2, true),
            'food_type_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7]),
            'price' => $this->faker->randomFloat(2, 3000, 20000),
            'created_user_id' => 1,
        ];
    }
}
