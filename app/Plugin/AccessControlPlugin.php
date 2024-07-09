<?php

namespace App\Plugin;

use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\FilamentAccessControlPlugin;
use Chiiya\FilamentAccessControl\Http\Livewire\Login;
use Chiiya\FilamentAccessControl\Http\Middleware\EnsureAccountIsNotExpired;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Chiiya\FilamentAccessControl\Resources\PermissionResource;
use Chiiya\FilamentAccessControl\Resources\RoleResource;
use Filament\Contracts\Plugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Panel;

class AccessControlPlugin extends FilamentAccessControlPlugin
{
    public function register(Panel $panel): void
    {
        $panel
            ->authGuard(config('auth.guard', 'web'))
            ->login(Login::class)
            ->authPasswordBroker('filament')
            ->passwordReset()
            ->authMiddleware([
                Authenticate::class,
                ...(Feature::enabled(Feature::ACCOUNT_EXPIRY) ? [EnsureAccountIsNotExpired::class] : []),
            ])
            ->resources([
                config('filament-access-control.resources.user', FilamentUserResource::class),
                config('filament-access-control.resources.permission', PermissionResource::class),
                config('filament-access-control.resources.role', RoleResource::class),
            ]);
    }
}
