<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = Room::all('room_no');
        foreach ($rooms as $room) {
            Table::create([
                'id' => $room->room_no,
                'table_type_id' => 1,
                'table_name' => 'Room-Table-' . $room->room_no,
                'created_user_id' => 1
            ]);
        }
    }
}
