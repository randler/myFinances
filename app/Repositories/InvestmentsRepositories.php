<?php

namespace App\Repositories;

use App\Models\Expenses;
use App\Models\Investments;
use App\Repositories\Interfaces\InvestmentsRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

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
            ->where('recurrence', 'monthly')
            ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
            ->where(function($query) {
                    $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', Carbon::now()->format('Y-m-d'));
            });
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
    
     // ======= API ======

    /**
     * List all investments
     * 
     * @return Investments
     */
    public function listAssets()
    {
        return Investments::where('user_id', auth()->id())
            ->get();
    }

     /**
     * Save a new investements
     * 
     * @param array<mixed> $data
     * 
     * @return Investments
     */
    public function store(array $data): Investments
    {
        try {
            $data['user_id'] = auth()->id();
            return Investments::create($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update a investements
     * 
     * @param array<mixed> $data
     * 
     * @return Investments
     */
    public function update(array $data): Investments
    {
        try {
            $investments = Investments::where('id', $data['id'])
                ->where('user_id', auth()->id())
                ->first();
            if(!$investments) {
                throw new \Exception('investments not found');
            }
            $investments->update($data);
            return $investments;
        } catch (\Exception $e) {
            throw $e;
        }
    }

     /**
     * Delete a investments
     * 
     * @param int $id
     * 
     * @return Investments
     */
    public function delete(int $id): Investments
    {
        try {
            $investments = Investments::where('id', $id)
                ->where('user_id', auth()->id())
                ->first();
            if(!$investments) {
                throw new \Exception('Investments asset not found');
            }
            $investments->delete();
            return $investments;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Find a investments by id
     * 
     * @param array<mixed> $data
     * 
     * @return Collection
     */
    public function find(array $data): Collection
    {
        $investments = Investments::where('user_id', auth()->id());

        if(isset($data['id'])) {
            $investments->where('id', $data['id']);
        }

        if(isset($data['title'])) {
            $investments->where('title', 'like', '%'.$data['title'].'%')
                ->orWhere('description', 'like', '%'.$data['title'].'%');
        }

        if(isset($data['recurrence'])) {
            $investments->where('recurrence', $data['recurrence']);
        }

        if(isset($data['amount'])) {
            $investments->whereBetween('amount', [$data['amount'] , $data['amount'] + 1000])
                ->orWhere('amount', '>=', $data['amount']);
        }

        if(isset($data['start_date'])) {
            $investments->where('start_date', '>=', $data['start_date']);
        }

        if(isset($data['end_date'])) {
            $investments->where('end_date', '<=', $data['end_date']);
        }

        $investments = $investments->get();
        
        if(!$investments) {
            throw new \Exception('Investments asset not found');
        }
        return $investments;
    }
}
