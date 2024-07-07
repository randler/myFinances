<?php

namespace App\Filament\Pages;

use App\Filament\Resources\FinanceAssetsResource\Widgets\StatsAssets;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm, InteractsWithPageFilters;

    public function getStats(): array
    {
        return [
            StatsAssets::make(),

                
            // ...
        ];
    }
}
