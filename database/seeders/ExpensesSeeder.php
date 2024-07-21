<?php

namespace Database\Seeders;

use App\Models\Expenses;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpensesSeeder extends Seeder
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
        for($i = 0; $i < 10; $i++) {
            $user = User::all()->random();
            Expenses::create([
                'title' => $faker->name,
                'description' => $faker->text,
                'amount' => $faker->randomFloat(2, 100, 1000),
                'amount_paid' => $faker->randomFloat(2, 100, 1000),
                'expiration_date' => $faker->date(),
                'paid_date'=> $faker->date(),
                'recurrence' => $faker->randomElement(['daily', 'weekly', 'monthly', 'yearly']),
                'start_date' => $faker->date(),
                'end_date' => $faker->date(),
                'user_id' => $user->id
            ]);
        }
    }
}
