<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Messages extends Component
{
    public bool $modal = false;
    public function render(): View
    {
        return view('livewire.messages', ['count' => 5]);
    }

    public function openModal()
    {
        $this->dispatch('open-modal', id: 'edit-user');
    }

}
