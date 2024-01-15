<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class platformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('platforms')->insert([
            'platform_name' => 'Facebook',
        ]);
        DB::table('platforms')->insert([
                'platform_name' => 'Twitter',
            ]);
            DB::table('platforms')->insert([
                'platform_name' => 'Instagram',
            ]);
            DB::table('platforms')->insert([
                'platform_name' => 'SnapShot',
            ]);
    }
}
