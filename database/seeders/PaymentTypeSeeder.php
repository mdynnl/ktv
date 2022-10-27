<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([
            'payment_type_name' => 'Cash'
        ]);
        PaymentType::create([
            'payment_type_name' => 'Card'
        ]);
        PaymentType::create([
            'payment_type_name' => 'Credit'
        ]);
    }
}
