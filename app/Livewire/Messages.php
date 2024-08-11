<?php

namespace App\Livewire;

use App\Models\Rooms;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Messages extends Component
{
    public function render(): View
    {
        return view('livewire.messages');
    }

    public function openModal()
    {
        $this->dispatch('open-modal', id: 'edit-user');
    }

    public function openModalNewChat()
    {
        $this->dispatch('open-modal', id: 'new-chat');
    }

}
