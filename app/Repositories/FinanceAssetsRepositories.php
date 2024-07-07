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
        $total = FinanceAssets::whereBetween(
                'created_at', 
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )->get()
            ->sum('amount');
        return $total;
    }
    public function getMonthEconomy(): float
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
        
        return $total;
    }    
}
