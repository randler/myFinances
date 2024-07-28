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
        return $expenses;
    }

    public function getCurrentMonthExpenses()
    {
        return Expenses::where('user_id', auth()->id())
            ->whereBetween(
                'expiration_date',
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth(),
                Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]
        );  
    }

    public function getMonthExpensesPaid(): float
    {
        $expenses = Expenses::whereBetween(
            'created_at',
            [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )->get()
            ->sum('amount_paid');

        // format to BRL
        return $expenses;
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
        return $total;
    }
    
}
