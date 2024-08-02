<?php

namespace App\Filament\Resources\ExpensesResource\Widgets;

use App\Models\Expenses;
use App\Repositories\ExpensesRepositories;
use Filament\Tables;
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
        $repository = new ExpensesRepositories();
        return $table
        ->paginated(false)
        ->query(
            $repository->getCurrentMonthExpenses()
        )
        ->columns([
            TextColumn::make('title')
                ->label('Título'),
            TextColumn::make('amount_paid')
                ->label('Total da Despesa Paga')
                ->money('brl'),
            TextColumn::make('amount_debit_month')
                ->label('Despesa Mensal')
                ->money('brl'),
            TextColumn::make('actual_value')
                ->label('Despesa Mês Atual')
                ->money('brl'),
            TextColumn::make('recurrence_month_formatted')
                ->label('Parcela'),
            TextColumn::make('total_parcel_paid')
                ->label('Parcelas Pagas'),
            TextColumn::make('expiration_day')
                ->label('dia do Vencimento')
                ->date('d'),
            TextColumn::make('end_date')
                ->label('Vencimento Final')
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
                        $expense->amount_paid = floatval($expense->amount_paid) + floatval($data['paid']);
                        if($expense->amount_paid >= $expense->amount) {
                            $expense->amount_paid = floatval($expense->amount);
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
