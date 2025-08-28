<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\TaskFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditTask extends Component
{
    use WithFileUploads;

    public $categories = [];

    public $task;

    #[Validate('required')]
    public string $title;

    #[Validate('required')]
    public string $description;

    #[Validate('required')]
    public string $due_date;

    #[Validate('required')]
    public string $category;

    #[Validate('required')]
    public string $status = 'todo';

    #[Validate('required')]
    public int $priority = 0;

    #[Validate('nullable|file|mimes:pdf|max:2048')]
    public $pdf; // file upload (no type-hint, Livewire handles it)

    public function update()
    {
        if ($this->task->user_id !== auth()->id()) {
            return redirect()->to('/tasks');
        }

        $this->validate();

        $this->task->update([
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'category_id' => $this->category,
            'status' => $this->status,
            'priority' => $this->priority,
        ]);

        if ($this->pdf) {
            $path = $this->pdf->store("task_files/{$this->task->id}", 'public');

            TaskFile::create([
                'task_id' => $this->task->id,
                'filename' => $this->pdf->getClientOriginalName(),
                'path' => $path,
            ]);
        }

        session()->flash('success', 'Task "'.$this->task->title.'" updated successfully.');

        return redirect()->to('/tasks');
    }

    public function delete()
    {
        if ($this->task->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        foreach ($this->task->fileRelation as $file) {
            if (Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }
            $file->delete();
        }

        $this->task->delete();

        session()->flash('delete', 'Task "'.$this->task->title.'" deleted.');

        return redirect()->to('/tasks');
    }

    public function mount($taskId)
    {
        if ($user = auth()->user()) {
            $this->categories = $user->categoryRelation()->get();
        }

        $task = $this->task = Task::where('id', $taskId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->title = $task->title;
        $this->description = $task->description;
        $this->due_date = $task->due_date;
        $this->category = $task->category_id;
        $this->status = $task->status;
        $this->priority = $task->priority;
    }

    public function render()
    {
        return view('livewire.edit-task');
    }
}
