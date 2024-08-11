<?php

namespace App\Repositories;

use App\Models\Expenses;
use App\Models\FinanceAssets;
use App\Repositories\Interfaces\FinanceRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

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
        return round($total, 2);
    }

    public function getCurrentMonthBalance()
    {   
        return FinanceAssets::where('user_id', auth()->id())
            ->where('recurrence', 'monthly')
            ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
            ->where(function($query) {
                    $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', Carbon::now()->format('Y-m-d'));
            });
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

        return round($total,2);
    }    



    // ======= API ======

    /**
     * List all finance assets
     * 
     * @return FinanceAssets
     */
    public function listAssets()
    {
        return FinanceAssets::where('user_id', auth()->id())
            ->get();
    }

    /**
     * Find a finance asset by id
     * 
     * @param array<mixed> $data
     * 
     * @return Collection
     */
    public function find(array $data): Collection
    {
        $financeAssets = FinanceAssets::where('user_id', auth()->id());

        if(isset($data['id'])) {
            $financeAssets->where('id', $data['id']);
        }

        if(isset($data['title'])) {
            $financeAssets->where('title', 'like', '%'.$data['title'].'%')
                ->orWhere('description', 'like', '%'.$data['title'].'%');
        }

        if(isset($data['recurrence'])) {
            $financeAssets->where('recurrence', $data['recurrence']);
        }

        if(isset($data['amount'])) {
            $financeAssets->whereBetween('amount', [$data['amount'] , $data['amount'] + 1000])
                ->orWhere('amount', '>=', $data['amount']);
        }

        if(isset($data['start_date'])) {
            $financeAssets->where('start_date', '>=', $data['start_date']);
        }

        if(isset($data['end_date'])) {
            $financeAssets->where('end_date', '<=', $data['end_date']);
        }

        $financeAssets = $financeAssets->get();
        
        if(!$financeAssets) {
            throw new \Exception('Finance asset not found');
        }
        return $financeAssets;
    }

    /**delete
     * Save a new finance asset
     * 
     * @param array<mixed> $data
     * 
     * @return FinanceAssets
     */
    public function store(array $data): FinanceAssets
    {
        try {
            $data['user_id'] = auth()->id();
            return FinanceAssets::create($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update a finance asset
     * 
     * @param array<mixed> $data
     * 
     * @return FinanceAssets
     */
    public function update(array $data): FinanceAssets
    {
        try {
            $financeAssets = FinanceAssets::where('id', $data['id'])
                ->where('user_id', auth()->id())
                ->first();
            if(!$financeAssets) {
                throw new \Exception('Finance asset not found');
            }
            $financeAssets->update($data);
            return $financeAssets;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete a finance asset
     * 
     * @param int $id
     * 
     * @return FinanceAssets
     */
    public function delete(int $id): FinanceAssets
    {
        try {
            $financeAssets = FinanceAssets::where('id', $id)
                ->where('user_id', auth()->id())
                ->first();
            if(!$financeAssets) {
                throw new \Exception('Finance asset not found');
            }
            $financeAssets->delete();
            return $financeAssets;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
