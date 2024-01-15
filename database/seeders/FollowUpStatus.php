<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowUpStatus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('followUpStatus')->insert([
            'follow_up_status' => 'waiting',
             'status_theme'=>'#E9D502'
        ]);
        DB::table('followUpStatus')->insert([
            'follow_up_status' => 'responded',
            'status_theme'=>'##22bb33'

        ]);
        DB::table('followUpStatus')->insert([
            'follow_up_status' => 'cancelled',
            'status_theme'=>'#ff0000'
        ]);
        DB::table('followUpStatus')->insert([
            'follow_up_status' => 'delayed',
            'status_theme'=>'#615f5f'
        ]);
    }
}
