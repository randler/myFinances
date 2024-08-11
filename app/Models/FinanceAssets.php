<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Repositories\FinanceAssetsRepositories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceAssets extends Model
{
    use HasFactory;
    
    protected $table = 'finance_assets';

    protected $casts = [
        'amount' => 'float',
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
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
