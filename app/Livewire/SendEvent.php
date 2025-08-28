<?php

namespace App\Livewire;

use Livewire\Component;

class SendEvent extends Component
{
    public string $newMessage;

    public function sendMessage()
    {
        $this->dispatch('messageSent', $this->newMessage)->to(ReceiveEvent::class);
    }

    public function resetMessage()
    {
        $this->dispatch('resetMessage');
    }

    public function render()
    {
        return view('livewire.send-event');
    }
}
