<?php

namespace App\Filament\Widgets;

use App\Repositories\ExpensesRepositories;
use App\Repositories\FinanceAssetsRepositories;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class FinancialChartOverview extends ChartWidget
{
    protected static ?string $heading = 'Despesas Planejadas do Mês 1 ';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $expensesRepository = new ExpensesRepositories();
        $assetsRepository = new FinanceAssetsRepositories();

        
        $ballanceInitial= $assetsRepository->getMonthBalance();
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
            plugins: {
                datalabels: {
                    anchor: 'start',
                    align: 'start',
                    position: 'chartArea',
                    formatter: function(value, context) {
                        value = value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                        return  value;
                    },
                    color: function(context) {
                        let index = context.dataIndex;
                        let value = context.dataset.data[index];

                        if(value > 200 ) {
                            return '#FFF';
                        } else if(value < 0) {
                            return '#FF0000';
                        }

                        return '#000';
                    },
                    font: {
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: (value) => 'R$ ' + value,
                    },
                },
            },
        }
    JS);
    }
}
