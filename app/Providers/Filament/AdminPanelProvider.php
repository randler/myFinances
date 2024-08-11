<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Resources\ExpensesResource\Widgets\ExpensesOverview;
use App\Filament\Resources\ExpensesResource\Widgets\ExpensesWidget;
use App\Filament\Resources\FinanceAssetsResource\Widgets\FinanceAssetsWidgets;
use App\Filament\Resources\FinanceAssetsResource\Widgets\StatsAssets;
use App\Filament\Resources\InvestmentsResource\Widgets\InvestmentsWidget;
use App\Filament\Widgets\FinancialChartOverview;
use App\Plugin\AccessControlPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('My Finance')
            ->plugin(AccessControlPlugin::make())
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->viteTheme(['resources/css/filament/admin/theme.css'])
            ->renderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn (): string => Blade::render('@livewire(\'messages\')'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => Blade::render('@livewire(\'new-chat\')'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => Blade::render('@livewire(\'chat-messages\')'),
            )
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label('Edit profile')
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                StatsAssets::class,
                //FinanceAssetsOverview::class,
                ExpensesOverview::class,
                FinancialChartOverview::class,
                ExpensesWidget::class,
                InvestmentsWidget::class,
                FinanceAssetsWidgets::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
