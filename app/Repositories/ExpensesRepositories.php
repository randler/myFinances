<?php

namespace App\Repositories;

use App\Models\Expenses;
use App\Models\FinanceAssets;
use App\Repositories\Interfaces\ExpensesRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

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
    
     // ======= API ======

    /**
     * List all Expenses
     * 
     * @return Expenses
     */
    public function listAssets()
    {
        return Expenses::where('user_id', auth()->id())
            ->get();
    }

      /**
     * Save a new expenses
     * 
     * @param array<mixed> $data
     * 
     * @return Expenses
     */
    public function store(array $data): Expenses
    {
        try {
            $data['user_id'] = auth()->id();
            return Expenses::create($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update a expenses
     * 
     * @param array<mixed> $data
     * 
     * @return Expenses
     */
    public function update(array $data): Expenses
    {
        try {
            $expenses = Expenses::where('id', $data['id'])
                ->where('user_id', auth()->id())
                ->first();
            if(!$expenses) {
                throw new \Exception('expenses not found');
            }
            $expenses->update($data);
            return $expenses;
        } catch (\Exception $e) {
            throw $e;
        }
    }

     /**
     * Delete a expenses
     * 
     * @param int $id
     * 
     * @return Expenses
     */
    public function delete(int $id): Expenses
    {
        try {
            $expenses = Expenses::where('id', $id)
                ->where('user_id', auth()->id())
                ->first();
            if(!$expenses) {
                throw new \Exception('Expenses asset not found');
            }
            $expenses->delete();
            return $expenses;
        } catch (\Exception $e) {
            throw $e;
        }
    }

     /**
     * Find a expenses by id
     * 
     * @param array<mixed> $data
     * 
     * @return Collection
     */
    public function find(array $data): Collection
    {
        $expenses = Expenses::where('user_id', auth()->id());

        if(isset($data['id'])) {
            $expenses->where('id', $data['id']);
        }

        if(isset($data['title'])) {
            $expenses->where('title', 'like', '%'.$data['title'].'%')
                ->orWhere('description', 'like', '%'.$data['title'].'%');
        }

        if(isset($data['recurrence_month'])) {
            $expenses->where('recurrence_month', $data['recurrence_month']);
        }

        if(isset($data['amount'])) {
            $expenses->whereBetween('amount', [$data['amount'] , $data['amount'] + 1000])
                ->orWhere('amount', '>=', $data['amount']);
        }

        if(isset($data['amount_paid'])) {
            $expenses->whereBetween('amount_paid', [$data['amount_paid'] , $data['amount_paid'] + 1000])
                ->orWhere('amount_paid', '>=', $data['amount_paid']);
        }

        if(isset($data['expiration_day'])) {
            $expenses->where('expiration_day', $data['expiration_day']);
        }

        if(isset($data['paid_date'])) {
            $expenses->where('paid_date', $data['paid_date']);
        }

        if(isset($data['start_date'])) {
            $expenses->where('start_date', '>=', $data['start_date']);
        }

        if(isset($data['end_date'])) {
            $expenses->where('end_date', '<=', $data['end_date']);
        }

        $expenses = $expenses->get();
        
        if(!$expenses) {
            throw new \Exception('Expenses asset not found');
        }
        return $expenses;
    }
}
