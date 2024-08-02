<?php

namespace App\Repositories;

use App\Models\Messages;

class MessageRepositories
{
    /**
     * Get all messages by room
     * 
     * @param int $roomId
     * 
     * @return Messages
     */
    public function getAllMessagesByRoom(int $roomId): Messages
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
