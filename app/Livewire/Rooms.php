<?php

namespace App\Livewire;

use App\Models\Rooms as ModelsRooms;
use Livewire\Component;

class Rooms extends Component
{
    protected $listeners = ['openChatRoom'];
    public function render()
    {
        $rooms = ModelsRooms::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();
        return view('livewire.rooms', compact('rooms'));
    }

    public function openRoomChatMessage($roomId)
    {
        $this->dispatch('openChatRoom', $roomId);
    }
}
