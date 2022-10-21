<?php

namespace Database\Seeders;

use App\Models\TableType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TableType::create([
            'table_type_name' => 'Room',
            'created_user_id' => 1,
        ]);
        TableType::create([
            'table_type_name' => 'Table',
            'created_user_id' => 1,
        ]);
        // TableType::create([
        //     'table_type_name' => 'Hall',
        //     'created_user_id' => 1,
        // ]);
    }
}
