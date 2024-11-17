<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collection = [
            [
                'name' => 'John Doe',
                'email' => 'mail@site.com',
                'password' => Hash::make(1234),
            ]
        ];

        DB::table('users')->insert($collection);
    }
}
