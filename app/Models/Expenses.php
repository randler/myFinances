<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $casts = [
        'amount' => MoneyCast::class,
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
        $this->end_date = Carbon::parse($this->start_date)->addMonth($this->recurrence_month);
    }

}
