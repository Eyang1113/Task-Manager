<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskList extends Component
{
    public $filter = 'all';
    public $category_id = 0;

    public function render()
    {
        $user = Auth::user();
        $query = $user->taskRelation();

        if ($this->category_id != 0) {
            $query->where('category_id', $this->category_id);
        }

        switch ($this->filter) {
            case 'todo':
            case 'in_progress':
            case 'done':
                $query->where('status', $this->filter)
                    ->orderBy('priority', 'desc');
                break;
            case 'overdue':
                $query->where('due_date', '<', \Illuminate\Support\Carbon::now('Asia/Kuala_Lumpur'))
                    ->whereIn('status', ['todo', 'in_progress']);
                break;
            case 'due-date':
                $query->orderBy('due_date', 'asc')
                    ->orderBy('priority', 'desc');
                break;
            default:
                $query->orderBy('priority', 'desc')
                    ->orderBy('id', 'asc');
                break;
        }

        $tasks = $query->with(['category', 'fileRelation'])
            ->orderBy('priority', 'desc')
            ->orderBy('id', 'asc')
            ->get();
        $categories = $user->categoryRelation()->get();

        return view('livewire.task-list', [
            'tasks' => $tasks,
            'categories' => $categories,
        ]);
    }
}
