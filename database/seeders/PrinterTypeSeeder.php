<?php

namespace Database\Seeders;

use App\Models\PrinterType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrinterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrinterType::create([
            'printer_name' => 'NPI8556AF (HP LaserJet Professional P1102w)',
            'printer_type' => 'Kitchen',
            'created_user_id' => 1,
        ]);
        PrinterType::create([
            'printer_name' => 'EPSON TM-T8 III Cashier',
            'printer_type' => 'Bar',
            'created_user_id' => 1,
        ]);
    }
}
