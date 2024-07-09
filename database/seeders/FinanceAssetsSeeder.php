<?php

namespace Database\Seeders;

use App\Models\FinanceAssets;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinanceAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /**
         *   $table->string('title')->nullable();
         */
        $faker = \Faker\Factory::create('pt_BR');
        // random user 
        for($i = 0; $i < 100; $i++) {
            $user = User::all()->random();
            FinanceAssets::create([
                'title' => $faker->name,
                'description' => $faker->text,
                'amount' => $faker->randomFloat(2, 100, 1000),
                'recurrence' => $faker->randomElement(['daily', 'weekly', 'monthly', 'yearly']),
                'start_date' => $faker->date(),
                'end_date' => $faker->date(),
                'user_id' => $user->id
            ]);
        }
    }
}
