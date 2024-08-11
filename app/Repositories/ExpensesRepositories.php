<?php

namespace App\Repositories;

use App\Models\Expenses;
use App\Models\FinanceAssets;
use App\Repositories\Interfaces\ExpensesRepositoryInterface;
use Carbon\Carbon;

class ExpensesRepositories implements ExpensesRepositoryInterface
{
    public function getMonthExpenses(): float
    {
        $expenses = Expenses::whereBetween(
            'created_at',
            [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )->get()
            ->sum('amount');

        // format to BRL
        return round($expenses, 2);
    }

    public function getCurrentMonthExpenses()
    {
        // start_date - end_date
        // expense -> 01/06/2023 - 30/09/2025
        // expense -> 01/06/2023 - null
        // 28/07/2024
        return Expenses::where('user_id', auth()->id())
            ->whereColumn('amount', '>=', 'amount_paid')
            ->where('start_date', '<=', Carbon::now())    
            ->where(function ($query) {
                $query->where('end_date', '>=', Carbon::now())
                        ->orWhereNull('end_date');
            });
    }

    public function getMonthExpensesPaid(): float
    {
        $expenses = Expenses::whereBetween(
            'created_at',
            [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )->get()
            ->sum('amount_paid');

        // format to BRL
        return round($expenses, 2);
    }

    public function getMonthExpensesToPaid(): float
    {
        $expensesToPaid = Expenses::whereBetween(
            'created_at',
            [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
        )->get()
            ->sum('amount');

        $expensesPaid = Expenses::whereBetween(
            'created_at',
            [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
        )->get()
            ->sum('amount_paid');

        $total = $expensesToPaid - $expensesPaid;

        // format to BRL
        return round($total, 2);
    }
    
}
