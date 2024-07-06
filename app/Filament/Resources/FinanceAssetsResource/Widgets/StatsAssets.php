<?php

namespace App\Filament\Resources\FinanceAssetsResource\Widgets;

use App\Models\FinanceAssets;
use App\Repositories\FinanceAssetsRepositories;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAssets extends BaseWidget
{
    protected function getStats(): array
    {
        $repository = new FinanceAssetsRepositories();
        $economy = $repository->getMonthEconomy();
        $colorEconomy = $economy > 0 ? 'success' : 'danger';
        return [
            Stat::make('Entradas do Mês', $repository->getMonthBalance())
                ->description('Saldo total do mês')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),
            Stat::make('Economia do Mês', $economy)
                ->description('Economia total do mês')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color($colorEconomy),
            Stat::make('Despesas do mês', $repository->getMonthExpenses())
                ->description('Total de despesas do mês')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('danger'),
            Stat::make('Despesas Restantes', $repository->getMonthRemainingExpenses())
                ->description('Total de despesas restantes do mês')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('danger'),
        ];
    }
}
