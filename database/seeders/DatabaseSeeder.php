<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Food;
use App\Models\RoomType;
use App\Models\ServiceStaff;
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
        $this->call(CurrentOperationDateSeeder::class);

        $this->call(CheckoutPaymentTypeSeeder::class);

        $this->call(UserSeeder::class);

        Customer::factory(50)->create();
        $this->call(ServiceStaffRateSeeder::class);
        ServiceStaff::factory(30)->create();

        $this->call(RoomTypeSeeder::class);
        $this->call(RoomSeeder::class);

        $this->call(TableTypeSeeder::class);
        $this->call(TableSeeder::class);

        $this->call(TransactionSeeder::class);

        $this->call(PrinterTypeSeeder::class);
        $this->call(FoodCategorySeeder::class);
        $this->call(FoodTypeSeeder::class);
        Food::factory(50)->create();
    }
}
