<?php

namespace App\Livewire;

use App\Models\Rooms;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class NewChat extends Component
{
    protected $listeners = ['openNewChat'];
    public $searchName = '';

    public function render()
    {
        $users = User::select('users.id', 'users.name')
            ->leftJoin('rooms', 'users.id', '=', 'rooms.receiver_id')
            ->whereNot('users.id', auth()->id())
            ->whereNull('rooms.receiver_id')
            ->when($this->searchName, function ($query) {
                return $query->where('name', 'like', '%' . $this->searchName . '%');
            })
            ->limit(10)
            ->get();
        return view('livewire.new-chat',  compact('users'));
    }

    public function updating($key)
    {
        if($key === 'searchName') {
            $this->reset();
        }
    }

    public function createChatRom($userId)
    {
        try {
            DB::beginTransaction();
            $room = new Rooms();
            $room->fill([
                'sender_id' => auth()->id(),
                'receiver_id' => $userId
            ])->save();
    
            $room->initMessage();
            DB::commit();
            
            $this->dispatch('close-modal', id: 'new-chat');
            $this->dispatch('openChatRoom', $room->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            DB::rollBack();
        }
    }
}
