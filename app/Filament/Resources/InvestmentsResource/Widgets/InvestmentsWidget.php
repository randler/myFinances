<?php

namespace App\Filament\Resources\InvestmentsResource\Widgets;

use App\Models\Investments;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class InvestmentsWidget extends BaseWidget
{
    protected static ?string $heading = 'Investimentos do Mês';
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->query(
                // pegar os investimentos do mês
                Investments::query()
                    ->latest()
                    ->limit(4)
            )
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('amount')
                    ->label('Investimentos')
                    ->money('brl'),
            ]);
    }
}
