<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceAssets extends Model
{
    use HasFactory;
    
    protected $casts = [
        'amount' => MoneyCast::class,
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

}
