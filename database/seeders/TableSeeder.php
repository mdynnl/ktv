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
        $rooms = Room::all('id');
        foreach ($rooms as $room) {
            Table::create([
                'id' => $room->id,
                'table_type_id' => 1,
                'table_name' => 'Room-Table-' . $room->id,
                'created_user_id' => 1
            ]);
        }
    }
}
