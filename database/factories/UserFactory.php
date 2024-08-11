<?php

namespace Database\Factories;

use App\Models\User;
use Chiiya\FilamentAccessControl\Database\Factories\FilamentUserFactory;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends FilamentUserFactory
{
    /**
     * The current password being used by the factory.
     */
    protected $model = User::class;

    public function definition(): array
    {
        
        $values = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];

        return $values;
    }
}
