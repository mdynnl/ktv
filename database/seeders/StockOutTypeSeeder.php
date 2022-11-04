<?php

namespace Database\Seeders;

use App\Models\StockOutType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockOutTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StockOutType::create([
            'stock_out_type_name' => 'House Use',
        ]);
        StockOutType::create([
            'stock_out_type_name' => 'Donation',
        ]);
        StockOutType::create([
            'stock_out_type_name' => 'Present',
        ]);
        StockOutType::create([
            'stock_out_type_name' => 'Damage',
        ]);
        StockOutType::create([
            'stock_out_type_name' => 'Waste',
        ]);
        StockOutType::create([
            'stock_out_type_name' => 'Lost',
        ]);
    }
}
