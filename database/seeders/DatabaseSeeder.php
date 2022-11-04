<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Food;
use App\Models\Item;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoomType;
use App\Models\ServiceStaff;
use App\Models\Supplier;
use App\Models\User;
use App\Policies\StockTypePolicy;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $key => $permission) {
            foreach ($permission as $perm) {
                Permission::firstOrCreate([
                    'name' => $perm,
                    'group_name' => $key
                ]);
            }
        }

        $roles = Role::defaultRoles();
        foreach ($roles as $role) {
            $role = Role::firstOrCreate(['name' => $role]);
            if ($role->name == 'Owner') {
                $role->syncPermissions(Permission::all());
                $this->command->info('Admin granted all the permissions');
            } else {
                $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
            }
        }

        $role = Role::where('name', 'Owner')->orWhere('name', 'Admin')->orWhere('name', 'Super Admin')->first();
        $user = User::first();
        $user->assignRole($role);


        $this->call(CurrentOperationDateSeeder::class);

        $this->call(ExpenseTypeSeeder::class);

        $this->call(StockOutTypeSeeder::class);

        $this->call(PaymentTypeSeeder::class);


        Customer::factory(50)->create();
        $this->call(ServiceStaffRateSeeder::class);
        ServiceStaff::factory(30)->create();

        $this->call(RoomTypeSeeder::class);
        $this->call(RoomSeeder::class);

        $this->call(TableTypeSeeder::class);
        $this->call(TableSeeder::class);

        $this->call(TransactionSeeder::class);

        Supplier::factory(20)->create();
        Item::factory(50)->create();

        $this->call(PrinterTypeSeeder::class);
        $this->call(FoodCategorySeeder::class);
        $this->call(FoodTypeSeeder::class);
        Food::factory(50)->create();
    }
}
