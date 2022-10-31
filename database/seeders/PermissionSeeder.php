<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $key => $permission) {
            foreach ($permission as $perm) {
                Permission::firstOrCreate([
                    'name' => $perm,
                    'group_name' => $key
                ]);
            }
        }
    }
}
