<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 101; $i < 151; $i++) {
            Room::create([
                'room_type_id' => random_int(1, 3),
                'room_no' => $i,
                'occupy_status' => false,
                'created_user_id' => 1
            ]);
        }
    }
}
