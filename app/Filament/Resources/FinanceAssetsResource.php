<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinanceAssetsResource\Pages;
use App\Models\FinanceAssets;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Date;
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
                    ->prefix('R$')
                    ->step('0.01')

                    ->mask(RawJs::make('$money($input)')),
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
                TextColumn::make('description'),
                TextColumn::make('amount')
                    ->money('BRL'),
                TextColumn::make('recurrence'),
                TextColumn::make('start_date')
                    ->date('d/m/Y'),
                TextColumn::make('end_date')
                    ->date('d/m/Y'),
                
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
