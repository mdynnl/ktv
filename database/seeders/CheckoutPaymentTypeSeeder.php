<?php

namespace Database\Seeders;

use App\Models\CheckoutPaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CheckoutPaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CheckoutPaymentType::create([
            'checkout_payment_type_name' => 'Cash'
        ]);
        CheckoutPaymentType::create([
            'checkout_payment_type_name' => 'Card'
        ]);
        CheckoutPaymentType::create([
            'checkout_payment_type_name' => 'City'
        ]);
    }
}
