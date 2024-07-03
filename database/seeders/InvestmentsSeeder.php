<?php

namespace Database\Seeders;

use App\Models\Investments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestmentsSeeder extends Seeder
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
            Investments::create([
                'title' => $faker->name,
                'description' => $faker->text,
                'amount' => $faker->randomFloat(2, 100, 1000),
                'recurrence' => $faker->randomElement(['daily', 'weekly', 'monthly', 'yearly']),
                'start_date' => $faker->date(),
                'end_date' => $faker->date(),

            ]);
        }

    }
}
