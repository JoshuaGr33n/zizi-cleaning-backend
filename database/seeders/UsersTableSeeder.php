<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'first_name' => 'Ozioma',
                'middle_name' => 'Bethel',
                'last_name' => 'Oleru',
                'username' => 'OziBeth7377744',
                'email' => 'contact@zizicleaners.com',
                'password' => Hash::make('12345678'), 
                'phone' => '07012345678',
                'role' => 'Admin',
            ],
            // [
            //     'id' => Str::uuid(),
            //     'first_name' => 'Staff',
            //     'middle_name' => '',
            //     'last_name' => 'James',
            //     'username' => 'Staff123456',
            //     'email' => 'staff@example.com',
            //     'password' => Hash::make('123456'),
            //     'phone' => '08012345678',
            //     'role' => 'Staff',
            // ],
            // [
            //     'id' => Str::uuid(),
            //     'first_name' => 'User',
            //     'middle_name' => '',
            //     'last_name' => 'Mike',
            //     'username' => 'User123456',
            //     'email' => 'user@example.com',
            //     'password' => Hash::make('123456'),
            //     'phone' => '09012345678',
            //     'role' => 'User',
            // ],
        ]);
    }
}
