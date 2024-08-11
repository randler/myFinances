<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'sender',
        'content'
    ];

    public function room()
    {
        return $this->belongsTo(Rooms::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sender');
    }
}
