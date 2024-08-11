<?php

namespace App\Filament\Resources\FinanceAssetsResource\Widgets;

use App\Models\FinanceAssets;
use App\Repositories\FinanceAssetsRepositories;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class FinanceAssetsWidgets extends BaseWidget
{
    protected static ?string $heading = 'Entradas do Mês';
    protected static ?int $sort = 5;

    public function table(Table $table): Table
    {   
        $repository = new FinanceAssetsRepositories();
        return $table
            ->paginated(false)
            ->query(
                $repository->getCurrentMonthBalance()
            )
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('amount')
                    ->label("Saldo")
                    ->money('brl'),
                TextColumn::make('start_date')
                    ->date('d/m/Y'),
            ]);
    }

}
