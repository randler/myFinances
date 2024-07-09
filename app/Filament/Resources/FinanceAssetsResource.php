<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinanceAssetsResource\Pages;
use App\Models\FinanceAssets;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class FinanceAssetsResource extends Resource
{
    protected static ?string $model = FinanceAssets::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                TextInput::make('description'),
                TextInput::make('amount')
                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2)
                    ->prefix('R$'),
                ToggleButtons::make('recurrence')
                    ->colors([
                        'daily' => 'info',
                        'weekly' => 'success',
                        'monthly' => 'warning',
                        'yearly' => 'danger',
                    ])
                    ->options([
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ]),
                DatePicker::make('start_date')
                    ->timezone('America/Sao_Paulo')
                    ->locale('pt-BR'),
                DatePicker::make('end_date')
                    ->timezone('America/Sao_Paulo')
                    ->locale('pt-BR')
                    ->nullable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $userId = auth()->user()->id;
                $query->where('user_id', $userId);
            })
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description'),
                TextColumn::make('amount')
                    ->money('BRL'),
                TextColumn::make('recurrence')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'daily' => 'info',
                        'weekly' => 'success',
                        'monthly' => 'warning',
                        'yearly' => 'danger'
                    }),
                TextColumn::make('start_date')
                    ->date('d/m/Y'),
                TextColumn::make('end_date')
                    ->date('d/m/Y'),
                TextColumn::make('user.name')
                
            ])
            ->filters([
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
            'index' => Pages\ListFinanceAssets::route('/'),
            'create' => Pages\CreateFinanceAssets::route('/create'),
            'edit' => Pages\EditFinanceAssets::route('/{record}/edit'),
        ];
    }
}
