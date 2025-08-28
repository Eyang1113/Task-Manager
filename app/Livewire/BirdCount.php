<?php

namespace App\Livewire;

use App\Models\Bird;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BirdCount extends Component
{
    #[Validate(['required', 'integer'])]
    public int $count;

    #[Validate(['required', 'string'])]
    public string $notes;

    public function submit()
    {
        //        $this->validate([
        //            'count' => ['required', 'integer'],
        //            'notes' => ['required', 'string'],
        //        ]);
        $this->validate();

        // Save to DB
        Bird::create([
            'bird_count' => $this->count,
            'notes' => $this->notes,
        ]);

        // Reset only the fields you want
        $this->reset();
    }

    public function delete($id)
    {
        Bird::find($id)->delete();
    }

    //    public function mount($birdCount)
    //    {
    //        // birdCount is initialized in <livewire:bird-count :birdCount="2" />
    //        $this->count = $birdCount;
    //    }

    public function render()
    {
        return view('livewire.bird-count', [
            'birds' => Bird::all(),
        ]);
    }
}
