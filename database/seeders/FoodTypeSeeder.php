<?php

namespace Database\Seeders;

use App\Models\FoodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $foods = ['Soup', 'Salad', 'Sandwich', 'Appetizer'];
        $beverages = ['Non-carbonated', 'Carbonated', 'alcoholic'];

        foreach ($foods as  $food) {
            FoodType::create([
                'food_category_id' => 1,
                'food_type_name' => $food,
                'created_user_id' => 1,
            ]);
        }

        foreach ($beverages as  $beverage) {
            FoodType::create([
                'food_category_id' => 2,
                'food_type_name' => $beverage,
                'created_user_id' => 1,
            ]);
        }
    }
}
