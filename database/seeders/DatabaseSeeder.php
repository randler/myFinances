<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // run command: artisan filament-access-control:install
        $this->call(UserAccessControlSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(FinanceAssetsSeeder::class);
        $this->call(ExpensesSeeder::class);
        $this->call(InvestmentsSeeder::class);
    }
}
