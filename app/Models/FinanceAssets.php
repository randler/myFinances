<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Repositories\FinanceAssetsRepositories;
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

    protected $fillable = [
        'title',
        'description',
        'amount',
        'recurrence',
        'start_date',
        'end_date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
