<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpensesResource\Pages;
use App\Filament\Resources\ExpensesResource\RelationManagers;
use App\Models\Expenses;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Date;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ExpensesResource extends Resource
{
    protected static ?string $model = Expenses::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                Textarea::make('description')
                    ->maxLength(255)
                    ->rows(5),
                TextInput::make('amount')
                    ->numeric()
                    ->inputMode('decimal')
                    ->prefix('R$'),
                TextInput::make('amount_paid')
                    ->numeric()
                    ->inputMode('decimal')
                    ->prefix('R$'),
                DatePicker::make('expiration_date')
                    ->timezone('America/Sao_Paulo')
                    ->locale('pt-BR'),
                DatePicker::make('paid_date')
                    ->timezone('America/Sao_Paulo')
                    ->locale('pt-BR')
                    ->nullable(),
                ToggleButtons::make('recurrence')
                    ->options([
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ]),
                DatePicker::make('start_date')
                    ->timezone('America/Sao_Paulo')
                    ->locale('pt-BR')
                    ->minDate(Date::now()),
                DatePicker::make('end_date')
                    ->timezone('America/Sao_Paulo')
                    ->locale('pt-BR')
                    ->nullable()
                    ->minDate(Date::now()),                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->color('gray')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                 
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                 
                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    }),
                TextColumn::make('amount')
                    ->money('BRL'),
                TextColumn::make('amount_paid')
                    ->money('BRL'),
                TextColumn::make('expiration_date')
                    ->date('d/m/Y'),
                TextColumn::make('paid_date')
                    ->date('d/m/Y'),    
                TextColumn::make('recurrence'),
                TextColumn::make('start_date')
                    ->date('d/m/Y'),
                TextColumn::make('end_date')
                    ->date('d/m/Y'),
            ])
            ->filters([
                DateRangeFilter::make('expiration_date')
                    ->label('Expiration Date')
                    ->placeholder('Expiration Date')
                    ->displayFormat('DD/MM/YYYY'),
                DateRangeFilter::make('paid_date')
                    ->label('Paid Date')
                    ->placeholder('Paid Date')
                    ->displayFormat('DD/MM/YYYY'),
                SelectFilter::make('recurrence')
                    ->multiple()
                    ->options([
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ]),
                DateRangeFilter::make('start_date')
                    ->label('Start Date')
                    ->placeholder('Start Date')
                    ->displayFormat('DD/MM/YYYY'),
                DateRangeFilter::make('end_date')
                    ->label('End Date')
                    ->placeholder('End Date'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpenses::route('/create'),
            'edit' => Pages\EditExpenses::route('/{record}/edit'),
        ];
    }
}
