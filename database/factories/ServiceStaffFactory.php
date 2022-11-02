<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceStaff>
 */
class ServiceStaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name_on_nrc' => fake()->name('female'),
            'nick_name' => fake()->name('female'),
            'nrc' => fake()->isbn10(),
            'dob' => fake()->date,
            'address' => fake()->address,
            'phone' => fake()->phoneNumber,
            'isActive' => fake()->boolean,
        ];
    }
}
