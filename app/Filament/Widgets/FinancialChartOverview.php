<?php

namespace App\Filament\Widgets;

use App\Repositories\ExpensesRepositories;
use App\Repositories\FinanceAssetsRepositories;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class FinancialChartOverview extends ChartWidget
{
    protected static ?string $heading = 'Despesas Planejadas do Mês';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $expensesRepository = new ExpensesRepositories();
        $assetsRepository = new FinanceAssetsRepositories();

        $ballanceInitial = $assetsRepository->getMonthBalance();
        $remaingBallance = $assetsRepository->getMonthEconomy();
        $expenses = $expensesRepository->getMonthExpenses();
        $expensesPaid = $expensesRepository->getMonthExpensesPaid();
        $expensesToPaid = $expensesRepository->getMonthExpensesToPaid();
        return [
            'datasets' => [
                [
                    'label' => 'Despesas Planejadas do Mês',
                    'data' => [$ballanceInitial, $remaingBallance, $expenses, $expensesPaid, $expensesToPaid],
                    'backgroundColor' => ['#334960', '#334960', '#ff392b', '#17ad23', '#f46524'],
                    'borderColor' => ['#334960', '#334960', '#ff392b', '#17ad23', '#f46524'],
                ],
            ],
            'labels' => ['Saldo Inicial', 'Saldo Restante', 'Despesas', 'Despesas Pagas', 'Despesas a restantes'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
        {
            scales: {
                y: {
                    ticks: {
                        callback: (value) => 'R$' + value,
                    },
                },
            },
        }
    JS);
    }
}
