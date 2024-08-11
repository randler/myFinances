<?php

namespace App\Repositories;

use App\Models\Expenses;
use App\Models\Investments;
use App\Repositories\Interfaces\InvestmentsRepositoryInterface;
use Carbon\Carbon;

class InvestmentsRepositories implements InvestmentsRepositoryInterface
{
    public function getMonthBalance(): float
    {
        $total = Investments::where('user_id', auth()->id())
            ->whereBetween(
                'created_at', 
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )->get()
            ->sum('amount');
        return $total;
    }

    public function getCurrentMonthBalance()
    {   
        return Investments::where('user_id', auth()->id())
            ->whereBetween(
                'start_date', 
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth(), 
                Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            );
    }

    public function getMonthEconomy(): float
    {
        $assets = Investments::where('user_id', auth()->id())
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
