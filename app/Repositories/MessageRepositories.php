<?php

namespace App\Repositories;

use App\Models\Messages;
use Illuminate\Database\Eloquent\Collection;

class MessageRepositories
{
    /**
     * Get all messages by room
     * 
     * @param int $roomId
     * 
     * @return Collection
     */
    public function getAllMessagesByRoom(int $roomId): Collection
    {
        return Messages::where('room_id', $roomId)
            ->get();
    }
    
    /**
     * Store a newly created resource in
     * 
     * @param int $roomId
     * @param string $content
     * 
     * @return Messages
     * 
     */
    public function store(int $roomId, string $content): Messages
    {
        return Messages::create([
            'room_id' => $roomId,
            'sender' => auth()->id(),
            'content' => $content
        ]);
    }
}
