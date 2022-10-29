<?php

namespace Database\Seeders;

use App\Models\ServiceStaffRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceStaffRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceStaffRate::create([
            'service_staff_rate' => 5000,
            'service_staff_commission_rate' => 2000,
            'created_user_id' => 1,
        ]);
    }
}
