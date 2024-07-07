<?php

namespace App\Filament\Resources\FinanceAssetsResource\Widgets;

use Filament\Widgets\ChartWidget;

class FinanceAssetsOverview extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
