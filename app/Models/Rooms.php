<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id'
    ];

    protected $appends = [
        'messages',
    ];

    public function getMessagesAttribute()
    {
        return $this->messages()->get();
    }

    /**
     * Get the user that owns the Rooms
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id'); 
    }

    public function messages()
    {
        return $this->hasMany(Messages::class, 'room_id');
    }


    public function getUserRoom()
    {
        $room = self::where('id', $this->id)
            ->where(function ($query) {
                $query->where('sender_id', auth()->id())
                    ->orWhere('receiver_id', auth()->id());
            })->first();
        //get id different auth
        $userIdDirect = $room->sender_id != auth()->id()
            ? $room->sender_id
            : $room->receiver_id;
        return User::find($userIdDirect);
    }


    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function initMessage()
    {
        $message = new Messages();
        $message->fill([
            'room_id' => $this->id,
            'sender' => auth()->id(),
            'content' => ''
        ])->save();
    }
}
