<?php

namespace App\Filament\Resources\InvestmentsResource\Widgets;

use App\Models\Investments;
use App\Repositories\InvestmentsRepositories;
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
        $repository = new InvestmentsRepositories();
        return $table
            ->paginated(false)
            ->query(
                $repository->getCurrentMonthBalance()
            )
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('amount')
                    ->label('Investimentos')
                    ->money('brl'),
            ]);
    }
}
