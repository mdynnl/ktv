<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpenseType::create([
            'expense_type_name' => 'Monthly Rental',
            'created_user_id' => 1,
        ]);

        ExpenseType::create([
            'expense_type_name' => 'Labor',
            'created_user_id' => 1,
        ]);

        ExpenseType::create([
            'expense_type_name' => 'Miscellaneous',
            'created_user_id' => 1,
        ]);
    }
}
