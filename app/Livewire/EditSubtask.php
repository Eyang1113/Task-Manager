<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditSubtask extends Component
{
    public $task;

    public $subtask;

    #[Validate('required')]
    public string $title;

    #[Validate('required')]
    public string $description;

    public function update()
    {
        if ($this->task->user_id !== auth()->id()) {
            return redirect()->to('/tasks');
        }

        if ($this->subtask->task_id !== $this->task->id) {
            abort(403);
        }

        $this->validate();

        $this->subtask->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Subtask "'.$this->subtask->title.'" updated successfully.');

        return redirect()->to('/taskDetail(lw)/'.$this->task->id);
    }

    public function mount($taskId, $subtaskId)
    {
        $this->task = Task::where('id', $taskId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->subtask = $this->task->subtaskRelation()
            ->where('id', $subtaskId)
            ->firstOrFail();

        $this->title = $this->subtask->title;
        $this->description = $this->subtask->description;
    }

    public function render()
    {
        return view('livewire.edit-subtask');
    }
}
