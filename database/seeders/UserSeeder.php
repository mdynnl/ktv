<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'name' => 'Zayar Tun',
            'username' => 'zayar-tun',
            'gender' => 'male',
            'nrc' => '12/ABC(N)123456',
            'dob' => '1982-06-29',
            'email' => 'zay@exm.com',
            'email_verified_at' => now(),
            'phone' => fake()->phoneNumber,
            'address' => fake()->address,
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'John Doe',
            'username' => 'ko-john',
            'gender' => 'Male',
            'nrc' => '12/ABC(N)123456',
            'dob' => '1992-02-19',
            'email' => 'john@exm.com',
            'email_verified_at' => now(),
            'phone' => fake()->phoneNumber,
            'address' => fake()->address,
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Jane Doe',
            'username' => 'jane-do',
            'gender' => 'Female',
            'nrc' => '12/ABC(N)123456',
            'dob' => '1992-02-19',
            'email' => 'jane@exm.com',
            'email_verified_at' => now(),
            'phone' => fake()->phoneNumber,
            'address' => fake()->address,
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Alex Smith',
            'username' => 'alex-smith',
            'gender' => 'Male',
            'nrc' => '12/ABC(N)123456',
            'dob' => '1998-01-19',
            'email' => 'alex@exm.com',
            'email_verified_at' => now(),
            'phone' => fake()->phoneNumber,
            'address' => fake()->address,
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
        ]);
    }
}
