<?php

namespace App\Livewire;

use App\Models\SubTask;
use App\Models\Task;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TaskDetail extends Component
{
    public $categories = [];
    public $task;

    public string $title;
    public string $description;
    public string $due_date;
    public string $category;
    public string $status = 'todo';
    public int $priority = 0;
    public $pdf;

    // Subtask properties (keep validation only for these)
    #[Validate('required|string')]
    public string $subtaskTitle = '';

    #[Validate('required|string')]
    public string $subtaskDescription = '';

    public bool $subtaskIs_done = false;

    public function addSubtask()
    {
        $this->validate();

        Subtask::create([
            'title' => $this->subtaskTitle,
            'description' => $this->subtaskDescription,
            'is_done' => $this->subtaskIs_done,
            'task_id' => $this->task->id,
        ]);

        session()->flash('success', 'Subtask "'.$this->subtaskTitle.'" created successfully.');

        $this->reset('subtaskTitle', 'subtaskDescription');
    }

    public function deleteSubtask(int $subtaskId)
    {
        if ($this->task->user_id !== auth()->id()) {
            return redirect()->to('/tasks');
        }

        $subtask = Subtask::where('id', $subtaskId)
            ->firstOrFail();
        $title = $subtask->title;
        $subtask->delete();

        session()->flash('delete', 'Subtask "'.$title.'" deleted.');
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
        return view('livewire.task-detail', [
            'subtasks' => SubTask::where('task_id', $this->task->id)
                ->orderBy('id')
                ->get(),
        ]);
    }
}
