<?php

namespace Database\Factories;

use App\Models\Inhouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InhouseService>
 */
class InhouseServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'inhouse_id' => Inhouse::factory()->create(),
            // 'service_staff_id' => fake()->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,17,18,18,21,22,23,24,25]),
            // 'checkin_time' => fake()->time()
        ];
    }
}
