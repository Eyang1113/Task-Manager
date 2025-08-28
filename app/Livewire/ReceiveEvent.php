<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class ReceiveEvent extends Component
{
    public string $message = 'No message';

    #[On('messageSent')]
    public function displayMessage($newMessage)
    {
        $this->message = $newMessage;
    }

    #[On('resetMessage')]
    public function resetMessage()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.receive-event');
    }
}
