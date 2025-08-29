<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\TaskFile;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddTask extends Component
{
    use WithFileUploads;

    #[Validate('required')]
    public string $title;

    #[Validate('required')]
    public string $description;

    #[Validate('required')]
    public string $due_date;

    #[Validate('required')]
    public string $category = '';

    #[Validate('required')]
    public string $status = 'todo';

    #[Validate('required')]
    public int $priority = 0;

    #[Validate('nullable|file|mimes:pdf|max:2048')]
    public $pdf; // file upload (no type-hint, Livewire handles it)

    public $categories = [];

    public function submit()
    {
        $this->validate();

        $task = Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'category_id' => $this->category,
            'status' => $this->status,
            'priority' => $this->priority,
            'user_id' => auth()->id(),
        ]);

        if ($this->pdf) {
            $path = $this->pdf->store("task_files/{$task->id}", 'public');

            TaskFile::create([
                'task_id' => $task->id,
                'filename' => $this->pdf->getClientOriginalName(),
                'path' => $path,
            ]);
        }

        session()->flash('success', 'Task "'.$task->title.'" created successfully.');

        return redirect()->to('/tasks');
    }

    public function mount()
    {
        if ($user = auth()->user()) {
            $this->categories = $user->categoryRelation()->get();
        }
    }

    public function render()
    {
        return view('livewire.add-task');
    }
}
