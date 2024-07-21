<?php

namespace App\Repositories;

use App\Models\Expenses;
use App\Models\FinanceAssets;
use App\Repositories\Interfaces\FinanceRepositoryInterface;
use Carbon\Carbon;

class FinanceAssetsRepositories implements FinanceRepositoryInterface
{
    public function getMonthBalance(): float
    {
        $total = FinanceAssets::where('user_id', auth()->id())
            ->whereBetween(
                'created_at', 
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )->get()
            ->sum('amount');
        return $total;
    }

    public function getCurrentMonthBalance()
    {   
        return FinanceAssets::where('user_id', auth()->id())
            ->whereBetween(
                'start_date', 
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth(), 
                Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            );
    }

    public function getMonthEconomy(): float
    {
        $assets = FinanceAssets::where('user_id', auth()->id())
            ->whereBetween(
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
        
        return $total;
    }    
}
