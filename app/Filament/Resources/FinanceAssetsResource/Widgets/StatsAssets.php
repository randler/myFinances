<?php

namespace App\Filament\Resources\FinanceAssetsResource\Widgets;

use App\Actions\CurrencyCast;
use App\Models\FinanceAssets;
use App\Repositories\ExpensesRepositories;
use App\Repositories\FinanceAssetsRepositories;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAssets extends BaseWidget
{
    protected static ?int $sort = 0;
    protected function getStats(): array
    {
        $expensesRepository = new ExpensesRepositories();
        $assetsRepository = new FinanceAssetsRepositories();
        $economy = $assetsRepository->getMonthEconomy();
        $colorEconomy = $economy > 0 ? 'success' : 'danger';
        return [
            Stat::make('Entradas do Mês', CurrencyCast::run($assetsRepository->getMonthBalance()))
                ->description('Saldo total do mês')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),
            Stat::make('Economia do Mês', CurrencyCast::run($economy))
                ->description('Economia total do mês')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color($colorEconomy),
            Stat::make('Despesas do mês', CurrencyCast::run($expensesRepository->getMonthExpenses()))
                ->description('Total de despesas do mês')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('danger'),
            Stat::make('Despesas Restantes', CurrencyCast::run($expensesRepository->getMonthExpensesToPaid()))
                ->description('Total de despesas restantes do mês')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('danger'),
        ];
    }
}
