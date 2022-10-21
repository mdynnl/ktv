<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomType::create([
            'room_type_name' => 'Silver',
            'room_rate' => 20000,
            'created_user_id' => 1
        ]);
        RoomType::create([
            'room_type_name' => 'Gold',
            'room_rate' => 40000,
            'created_user_id' => 1
        ]);
        RoomType::create([
            'room_type_name' => 'Platinum',
            'room_rate' => 60000,
            'created_user_id' => 1
        ]);
    }
}
