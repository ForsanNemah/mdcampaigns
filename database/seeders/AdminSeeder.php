<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'name' => 'yaser',
            'user_type' => 'admin',
            'user_phone'=> '715330678',
        ]);
        DB::table('accounts')->insert([
            'email' => 'yaser@gmail.com',
            'password' => Hash::make('12345678'),
            'accountable_type' => 'App\Models\User',
            'accountable_id' => '1',
        ]);

    }
}
