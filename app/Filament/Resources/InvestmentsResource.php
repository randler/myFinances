<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvestmentsResource\Pages;
use App\Models\Investments;
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
use Illuminate\Support\Facades\Date;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class InvestmentsResource extends Resource
{
    protected static ?string $model = Investments::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Titulo'),
                Textarea::make('description')
                    ->label('Descrição')
                    ->maxLength(255)
                    ->rows(5),
                TextInput::make('amount')
                    ->label('Valor')
                    ->numeric()
                    ->inputMode('decimal')
                    ->prefix('R$'),
                    ToggleButtons::make('recurrence')
                    ->label('Recorrencia')
                    ->colors([
                        'daily' => 'info',
                        'weekly' => 'success',
                        'monthly' => 'warning',
                        'yearly' => 'danger',
                    ])
                    ->options([
                        'daily' => 'Dia',
                        'weekly' => 'Semana',
                        'monthly' => 'Mês',
                        'yearly' => 'ano',
                    ]),
                DatePicker::make('start_date')
                    ->label('Data de Inicio')
                    ->timezone('America/Sao_Paulo')
                    ->locale('pt-BR')
                    ->minDate(Date::now()),
                DatePicker::make('end_date')
                    ->label('Data do fim')
                    ->timezone('America/Sao_Paulo')
                    ->locale('pt-BR')
                    ->nullable()
                    ->minDate(Date::now()),              
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
                ->label('Titulo')
                ->searchable()
                ->sortable(),
                TextColumn::make('description')
                ->label('Descrição')
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
                    TextColumn::make('recurrence')
                    ->label('Recorrencia')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'daily' => 'info',
                        'weekly' => 'success',
                        'monthly' => 'warning',
                        'yearly' => 'danger'
                    }),
                TextColumn::make('start_date')
                    ->label('Data de Inicio')
                    ->date('d/m/Y'),
                TextColumn::make('end_date')
                    ->label('Dato do Fim')
                    ->date('d/m/Y'),
            ])
            ->filters([
                SelectFilter::make('recurrence')
                    ->label('Recorrencia')
                    ->multiple()
                    ->options([
                        'daily' => 'Dia',
                        'weekly' => 'Semana',
                        'monthly' => 'Mês',
                        'yearly' => 'Ano',
                    ]),
                DateRangeFilter::make('start_date')
                    ->label('Data de Inico')
                    ->placeholder('Data de Inicio')
                    ->displayFormat('DD/MM/YYYY'),
                DateRangeFilter::make('end_date')
                    ->label('Data do Fim')
                    ->placeholder('Data do Fim'),
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
            'index' => Pages\ListInvestments::route('/'),
            'create' => Pages\CreateInvestments::route('/create'),
            'edit' => Pages\EditInvestments::route('/{record}/edit'),
        ];
    }
}
