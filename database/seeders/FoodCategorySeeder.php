<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FoodCategory::create([
            'food_category_name' => 'Food',
            'created_user_id' => 1
        ]);
        FoodCategory::create([
            'food_category_name' => 'Beverage',
            'created_user_id' => 1
        ]);
    }
}
