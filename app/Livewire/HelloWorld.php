<?php

namespace App\Livewire;

use Livewire\Component;

class HelloWorld extends Component
{
    public int $count = 10;
    public int $number;

    public function changeCount(int $number)
    {
        $this->count = $number;
    }

    public function render()
    {
        return view('livewire.hello-world');
    }
}
