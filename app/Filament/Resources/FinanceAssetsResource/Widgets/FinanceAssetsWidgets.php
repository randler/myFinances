<?php

namespace App\Filament\Resources\FinanceAssetsResource\Widgets;

use App\Models\FinanceAssets;
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
        return $table
            ->paginated([4])
            ->query(
                FinanceAssets::query()->latest()
            )
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('amount')
                    ->label("Saldo")
                    ->money('brl'),
            ]);
    }

}
