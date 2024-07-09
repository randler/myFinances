<?php

namespace App\Filament\Resources\ExpensesResource\Widgets;

use App\Models\Expenses;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ExpensesWidget extends BaseWidget
{   
    protected static ?string $heading = 'Despesas Planejadas do Mês';
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
        ->paginated([4])
        ->query(
            Expenses::query()->latest()
        )
        ->columns([
            TextColumn::make('title'),
            TextColumn::make('amount')
                ->prefix('R$ '),
            TextColumn::make('amount_paid')
                ->prefix('R$ '),
            TextColumn::make('expiration_date')
                ->date('d/m/Y'),
        ]);
    }
}
