<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'supplier_name' => fake()->company,
            'contact_person' => fake()->name('male'),
            'phone' => fake()->phoneNumber,
            'address' => fake()->address,
            'email' => fake()->email,
            'created_user_id' => 1,
        ];
    }
}
