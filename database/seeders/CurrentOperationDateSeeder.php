<?php

namespace Database\Seeders;

use App\Models\CurrentOperationDate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrentOperationDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CurrentOperationDate::create(['operation_date' => today()->toDateString()]);
    }
}
