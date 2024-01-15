<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Campaign;
use App\Models\Customer;
use App\Models\FollowUpStatus_Register;
use App\Models\Register;
use Illuminate\Database\Seeder;
use function Sodium\increment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


      $this->call([
           AdminSeeder::class,
           platformSeeder::class,
           FollowUpStatus::class
        ]);
    }
}
