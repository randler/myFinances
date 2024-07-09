<?php

namespace App\Console\Commands;

use App\Models\User;
use Chiiya\FilamentAccessControl\Enumerators\RoleName;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user super admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $values = [
            'name' => text(label: 'Name', required: true),
            'email' => text(
                label: 'Email address',
                required: true,
                validate: static fn (string $email): ?string => match (true) {
                    !filter_var($email, FILTER_VALIDATE_EMAIL) => 'The email address must be valid.',
                    User::query()->where(
                        'email',
                        '=',
                        $email,
                    )->exists() => 'A user with this email address already exists',
                    default => null,
                },
            ),
            'password' => Hash::make(password(label: 'Password', required: true)),
        ];

        $user = User::create($values);
        $user->assignRole(RoleName::SUPER_ADMIN);
        $user->save();
        $this->info("Success! {$user->email} may now log in.");

        return self::SUCCESS;
    }
}
