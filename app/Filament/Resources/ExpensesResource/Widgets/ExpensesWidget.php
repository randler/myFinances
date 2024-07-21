<?php

namespace App\Filament\Resources\ExpensesResource\Widgets;

use App\Models\Expenses;
use App\Repositories\ExpensesRepositories;
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
        $repository = new ExpensesRepositories();
        return $table
        ->paginated([4])
        ->query(
            $repository->getCurrentMonthExpenses()
        )
        ->columns([
            TextColumn::make('title'),
            TextColumn::make('amount')
                ->label('Despesas')
                ->money('brl'),
            TextColumn::make('amount_paid')
                ->label('Despesas Pagas')
                ->money('brl'),
            TextColumn::make('expiration_date')
                ->label('Vencimento')
                ->date('d/m/Y'),
        ]);
    }
}
