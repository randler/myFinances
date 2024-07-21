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
            ->paginated(false)
            ->query(
                // pegar as entrada do mês
                FinanceAssets::query()
                    ->latest()
                    ->limit(4)
            )
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('amount')
                    ->label("Saldo")
                    ->money('brl'),
            ]);
    }

}
