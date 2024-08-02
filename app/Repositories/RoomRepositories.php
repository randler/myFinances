<?php

namespace App\Repositories;

use App\Models\Messages;
use App\Models\Rooms;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RoomRepositories
{
    /**
     * Get all rooms
     * 
     * @return Collection
     */
    public function allMyRooms(): Collection
    {
        return Rooms::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();
    }    

    /**
     * Store a newly created resource in
     * 
     * @param int $receiverId
     * 
     * @return \App\Models\Rooms
     */
    public function store(int $receiverId): Rooms
    {
        try {
            DB::beginTransaction();
            $room = Rooms::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $receiverId
            ]);
    
            Messages::create([
                'room_id' => $room->id,
                'sender' => auth()->id(),
                'content' => ''
            ]);
            DB::commit();
            return $room;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
