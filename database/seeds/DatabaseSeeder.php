<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'manager'],
            ['name' => 'teacher'],
            ['name' => 'user']
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'role_id' => 1,
            'gender' => 1,
            'address' => 'Địa chỉ 1',
            'date_of_birth' => '2021-05-13 00:00:00',
            'code' => '12345678910',
            'phone' => 0928583902,
            
        ]);

    }
}
