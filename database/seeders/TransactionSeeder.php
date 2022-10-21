<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::create([
            'transaction_name' => 'Adjustment (+)',
            'isAddition' => true,
            'created_user_id' => 1,
        ]);
        Transaction::create([
            'transaction_name' => 'Adjustment (-)',
            'isAddition' => false,
            'created_user_id' => 1,
        ]);
    }
}
