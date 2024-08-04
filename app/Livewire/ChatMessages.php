<?php

namespace App\Livewire;

use App\Events\NewMessageEvent;
use App\Models\Messages;
use App\Models\Rooms;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatMessages extends Component
{
    public $roomId = 0;
    public $receiverName = '';
    public $messages = [];
    public $message = '';

    public function getListeners()
    {
        return [
            "echo-private:rooms.{$this->roomId},NewMessageEvent" => '$refresh',
        ];
    }

    public function render()
    {
        return view('livewire.chat-messages');
    }
    
    #[On('openChatRoom')]
    public function openChatRoom($roomId)
    {
        $this->roomId = $roomId;
        $this->receiverName = Rooms::find($roomId)->getUserRoom()->name;
        // get messages
        $this->messages = Messages::where('room_id', $roomId)->get();
        // open modal with chat room
        $this->dispatch('open-modal', id: 'chat-room-message');

        $this->getListeners();
    }

    public function sendMessage()
    {
        try {
            DB::beginTransaction();
            $message = new Messages();
            $message->fill([
                'room_id' => $this->roomId,
                'sender' => auth()->id(),
                'content' => $this->message
            ])->save();

            NewMessageEvent::dispatch(Rooms::find($this->roomId));

            $this->message = '';
            $this->messages = Messages::where('room_id', $this->roomId)->get();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        
    }
}
