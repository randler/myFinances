<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $casts = [
        //'amount' => MoneyCast::class,
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'description',
        'amount',
        'amount_paid',
        'expiration_day',        
        'paid_date',
        'recurrence_month',
        'start_date',
        'end_date',
        'user_id',
    ];

    protected $appends = [
        'amount_debit_month',
        'recurrence_month_formatted',
        'total_parcel_paid'
    ];

    public function getAmountDebitMonthAttribute()
    {
        return $this->amount / $this->recurrence_month;
    }

    public function getTotalParcelPaidAttribute()
    {
        $valueParcel = $this->amount / $this->recurrence_month;
        if($this->amount_paid >= $this->amount) {
            return "Pago";
        }
        $totalParcelPaid = 0;
        $valueParcelPaid = 0;
        while ($valueParcelPaid < $this->amount_paid) {
            $totalParcelPaid++;
            $valueParcelPaid += $valueParcel;
        }
        return "{$totalParcelPaid}/{$this->recurrence_month}";
    }

    public function getRecurrenceMonthFormattedAttribute()
    {
        // add 10 month
        $actualMonth = Carbon::now();
        $lastMonth = Carbon::parse($this->end_date);
        $total = $this->recurrence_month;
        // return diference value int months
        $diffMonth = floor($actualMonth->diffInMonths($lastMonth));
        $diffMonth = $diffMonth < 0 ? $total : $diffMonth;
        $remaining = $total - $diffMonth;
        if($remaining <= 0) return "Finalizado";
        return "{$remaining}/{$total}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @Override
     */
    public function save(array $options = [])
    {
        if ($this->recurrence_month && !$this->end_date) {
            $this->setEdnDate();
        }
        parent::save($options);   
    }

    /**
     * @Override
     */
    public function update(array $attributes = [], array $options = [])
    {
        if ($this->recurrence_month) {
            $this->setEdnDate();
        }
        parent::update($attributes, $options);
    }

    private function setEdnDate()
    {
        $endDate = Carbon::parse($this->start_date)
            ->addMonths(intval($this->recurrence_month));
        $this->end_date = $endDate;
    }

}
