<?php

namespace App\Filament\Resources\ExpensesResource\Widgets;

use App\Repositories\ExpensesRepositories;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class ExpensesOverview extends ChartWidget
{
    protected static ?string $heading = 'Despesas Planejadas do Mês';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $repository = new ExpensesRepositories();
        $planned = $repository->getMonthExpenses();
        $paid = $repository->getMonthExpensesToPaid();
        return [
            'datasets' => [
                [
                    'label' => 'Despesas Planejadas do Mês',
                    'data' => [$planned, $paid],
                    'backgroundColor' => ['#bd0b0b', '#17ad23'],
                    'borderColor' => ['#bd0b0b','#17ad23'],
                ],
            ],
            'labels' => ['Planejado', 'Pago'],
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
            indexAxis: 'y',
            scales: {
                x: {

                    ticks: {
                        callback: (value) => 'R$' + value,
                    },
                },
            },
        }
    JS);
    }

}
