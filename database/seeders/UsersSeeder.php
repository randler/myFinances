<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin'),
            'email_verified_at' => now(),
        ]);
        /**
         *   $table->string('title')->nullable();
         */
        $faker = \Faker\Factory::create('pt_BR');
        for($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ]);
        }

    }
}
