<?php

namespace App\Http\Controllers;

use App\Models\SubTask;
use App\Models\Task;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    public function createSubtask(Request $request, Task $task) {
        if ($task->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        $incomingData = $request -> validate([
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $incomingData['title'] = strip_tags($incomingData['title']);
        $incomingData['description'] = strip_tags($incomingData['description']);
        $incomingData['is_done'] = false;
        $incomingData['task_id'] = $task->id;

        SubTask::create($incomingData);

        return redirect(route('task.detail', ['task' => $task->id]))
            ->with('success', 'Subtask "' . $incomingData['title'] . '" created successfully.');
    }

    public function updateSubtaskStatus(Request $request, Task $task){
        if ($task->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        $checkedIds = $request->input('subtask', []);

        // Mark all task's subtasks as not done
        $task->subtaskRelation()->update(['is_done' => false]);

        // Mark only the selected ones as done
        if (!empty($checkedIds)) {
            $task->subtaskRelation()->whereIn('id', $checkedIds)->update(['is_done' => true]);
        }

        return redirect()->route('task.detail', ['task' => $task->id])
            ->with('success', 'Subtask statuses updated successfully.');
    }

    public function editSubtask(Task $task, Subtask $subtask) {
        if ($task->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        // Ensure the subtask belongs to the task
        if ($subtask->task_id !== $task->id) {
            return redirect('dashboard');
        }

        return view('editSubtask', [
            'task' => $task,
            'subtask' => $subtask,
        ]);
    }

    public function updateSubtask(Request $request, Task $task, Subtask $subtask){
        if ($task->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        $incomingData = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $incomingData['title'] = strip_tags($incomingData['title']);
        $incomingData['description'] = strip_tags($incomingData['description']);

        $subtask->update($incomingData);

        return redirect()->route('task.detail', ['task' => $task->id])
            ->with('success', 'Subtask "' . $incomingData['title'] . '" updated successfully.');
    }

    public function deleteSubtask(Task $task, Subtask $subtask){
        if ($task->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        $subtask->delete();

        return redirect()->route('task.detail', ['task' => $task->id])
            ->with('delete', 'Subtask "' . $subtask->title . '" deleted.');
    }
}
