<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('1234')
            ],
            [
                'username' => 'waiter',
                'role' => 'waiter',
                'password' => Hash::make('1234')
            ],
            [
                'username' => 'kasir',
                'role' => 'cashier',
                'password' => Hash::make('1234')
            ],
            [
                'username' => 'owner',
                'password' => Hash::make('1234')
            ],
        ];
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
