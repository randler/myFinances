<?php

namespace App\Repositories;

use App\Models\Expenses;
use App\Models\FinanceAssets;
use App\Repositories\Interfaces\FinanceRepositoryInterface;
use Carbon\Carbon;

class FinanceAssetsRepositories implements FinanceRepositoryInterface
{
    public function getMonthBalance(): string
    {
        $total = FinanceAssets::whereBetween(
                'created_at', 
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )->get()
            ->sum('amount');
        // format to BRL
        return number_format($total, 2, ',', '.');
    }
    public function getMonthEconomy(): string
    {
        $assets = FinanceAssets::whereBetween(
            'created_at',
            [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )->get()
            ->sum('amount');

        $expenses = Expenses::whereBetween(
            'created_at',
            [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )->get()
            ->sum('amount'); 

        $total = $assets - $expenses;
        
        // format to BRL
        return number_format($total, 2, ',', '.');
    }
    public function getMonthExpenses(): string
    {
        $expenses = Expenses::whereBetween(
            'created_at',
            [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )->get()
            ->sum('amount');

        // format to BRL
        return number_format($expenses, 2, ',', '.');
    }
    public function getMonthRemainingExpenses(): string
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
        return number_format($total, 2, ',', '.');
    }
    
}
