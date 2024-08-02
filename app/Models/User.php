<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Chiiya\FilamentAccessControl\Database\Factories\FilamentUserFactory;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends FilamentUser
{
    use HasApiTokens, HasFactory;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Provides full name of the current filament user.
     */
    public function getFullNameAttribute(): string
    {
        return $this->attributes['name'];
    }


    public function getFilamentName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Return a name.
     *
     * Needed for compatibility with filament-logger.
     */
    public function getNameAttribute(): string
    {
        return $this->getFilamentName();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function financeAssets()
    {
        return $this->hasMany(FinanceAssets::class);
    }

    /**
     * {@inheritDoc}
     */
    protected static function newFactory(): FilamentUserFactory
    {
        return UserFactory::new();
    }
}
