<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $mejaData = [];
        for ($i = 0; $i < 20; $i++) {
            $mejaData[] = [
                'table_number' => 'M' . str_pad($i + 1, 2, '0', STR_PAD_LEFT),  // e.g., M01, M02, ...
                'seats' => $faker->numberBetween(2, 10),
                'status' => 'available',
                'location' => $faker->randomElement(['indoor', 'outdoor', 'vip']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('tables')->insert($mejaData);
    }
}
