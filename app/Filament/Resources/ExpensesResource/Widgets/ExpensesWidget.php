<?php

namespace App\Filament\Resources\ExpensesResource\Widgets;

use App\Models\Expenses;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;

class ExpensesWidget extends BaseWidget
{   
    protected static ?string $heading = 'Despesas Planejadas do Mês';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 6;

    public function table(Table $table): Table
    {   
        return $table
        ->paginated(false)
        ->query(
            Expenses::query()->latest()
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
        ])
        ->actions([
            Action::make('Pay')
                ->form([
                        Radio::make('pay_status')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ])->default('1')
                            ->label('Deseja pagar essa tudo?')
                            ->live(),
                        TextInput::make('paid')
                            ->label('Valor')
                            ->numeric()
                            ->inputMode('decimal')
                            ->prefix('R$')
                            ->visible(fn ($record, $get) => $get('pay_status') == '0')
                    ])
                ->action(function (array $data, Expenses $expense, Action $action,  Form $form): void  {
                    if($data['pay_status'] == '1'){
                        $expense->amount_paid = $expense->amount;
                        $expense->paid_date = now();
                    } else {
                        $expense->amount_paid = $expense->amount_paid + floatval($data['paid']);
                        if($expense->amount_paid >= $expense->amount) {
                            $expense->amount_paid = $expense->amount;
                        }
                        $expense->paid_date = now();
                    }
                    $expense->update();
                })
                //->modalSubmitAction(false)
                ->modalHeading(false)
                ->modalContent(fn (Expenses $expense): View => view(
                'filament.pages.actions.action-pay-overview',
                    ['expense' => $expense],
                ))
                
        ]);
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {

        // remove pagination
        return $query->simplePaginate($query->count());
        //return $query->simplePaginate($this->getTableRecordsPerPage() == -1 ? $query->count() : $this->getTableRecordsPerPage());
    }

}
