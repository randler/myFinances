<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpensesResource\Pages;
use App\Models\Expenses;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ExpensesResource extends Resource
{
    protected static ?string $model = Expenses::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->label('Título')
                    ->placeholder('Título'),
                Textarea::make('description')
                    ->label('Descrição')
                    ->placeholder('Descrição')
                    ->maxLength(255)
                    ->rows(5),
                Money::make('amount')
                    ->label('Valor')
                    ->placeholder('Valor')
                    ->required()
                    ->prefix('R$'),
                Money::make('amount_paid')
                    ->label('Valor Pago')
                    ->placeholder('Valor Pago')
                    ->required()
                    ->prefix('R$'),
                DatePicker::make('expiration_day')
                    ->native(false)
                    ->label('Dia do Vencimento')
                    ->default(Date::now())
                    ->displayFormat('d')
                    ->format('d'),
                DatePicker::make('paid_date')
                    ->label('Data de Pagamento')
                    ->timezone('America/Sao_Paulo')
                    ->locale('pt-BR')
                    ->nullable(),
                TextInput::make('recurrence_month')
                    ->label('Total de Meses')
                    ->numeric()
                    ->integer()
                    ->placeholder('Total de meses')
                    ->minValue(1)
                    ->suffix('X Meses'),
                DatePicker::make('start_date')
                    ->label('Data de Início')
                    ->timezone('America/Sao_Paulo')
                    ->locale('pt-BR')
                    ->default(Date::now())                
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
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Descrição')
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
                    ->label('Valor')
                    ->money('BRL'),
                TextColumn::make('amount_paid')
                    ->label('Valor Pago')
                    ->money('BRL'),
                TextColumn::make('expiration_day')
                    ->label('Dia do Vencimento')
                    ->dateTime('d'),
                TextColumn::make('paid_date')
                    ->label('Data de Pagamento')
                    ->date('d/m/Y'),    
                TextColumn::make('recurrence_month')
                    ->label('Total de Meses'),
                TextColumn::make('start_date')
                    ->label('Data de Início')
                    ->date('d/m/Y'),
                TextColumn::make('end_date')
                    ->label('Data de Término')
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),

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
