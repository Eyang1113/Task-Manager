<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubTask;
use App\Models\TaskFile;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use SweetAlert2\Laravel\Swal;

class TaskController extends Controller
{
    public function addTask(){
        $user = auth()->user();
        $query = $user->categoryRelation();

        $categories = $query->get();

        return view('addTask', [
            'categories' => $categories,
        ]);
    }

    public function createTask(Request $request){
        $incomingData = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'due_date' => ['required'],
            'category' => ['required'],
            'status' => ['nullable'],
            'priority' => ['nullable'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:5120']
        ]);

        // Sanitize required fields
        $incomingData['title'] = strip_tags($incomingData['title']);
        $incomingData['description'] = strip_tags($incomingData['description']);
        $incomingData['due_date'] = strip_tags($incomingData['due_date']);
        $incomingData['category_id']=strip_tags($incomingData['category']);
        $incomingData['status'] = strip_tags($incomingData['status']);
        $incomingData['priority'] = strip_tags($incomingData['priority']);
        $incomingData['user_id'] = auth()->id();
        //dd($incomingData['priority']);
        $task = Task::create($incomingData);

        if ($request->hasFile('pdf')) {
            $path = $request->file('pdf')->store("task_files/{$task->id}", 'public');

            TaskFile::create([
                'task_id' => $task->id,
                'filename' => $request->file('pdf')->getClientOriginalName(),
                'path' => $path,
            ]);
        }

        Swal::success([
            'title' => 'Task "' . $incomingData['title'] . '" created successfully.',
        ]);

        return redirect('dashboard')->with('success', 'Task "' . $incomingData['title'] . '" created successfully.');
    }

    public function editTask(Task $task){
        if ($task->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        //to get the category details
        $task->load('category');

        //to get the user's categories
        $user = auth()->user();
        $query = $user->categoryRelation();
        $categories = $query->get();

        return view('editTask', [
            'task' => $task,
            'categories' => $categories,
        ]);
    }

    public function updateTask(Request $request, Task $task){
        // Check if the post belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        $incomingData = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'due_date' => ['required'],
            'category' => ['required'],
            'status' => ['required'],
            'priority' => ['required'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:5120']
        ]);

        // Sanitize required fields
        $incomingData['title'] = strip_tags($incomingData['title']);
        $incomingData['description'] = strip_tags($incomingData['description']);
        $incomingData['due_date'] = strip_tags($incomingData['due_date']);
        $incomingData['category_id']=strip_tags($incomingData['category']);
        $incomingData['status'] = strip_tags($incomingData['status']);
        $incomingData['priority'] = strip_tags($incomingData['priority']);

        // Update the task
        $task->update($incomingData);

        if ($request->hasFile('pdf')) {
            $path = $request->file('pdf')->store("task_files/{$task->id}", 'public');

            TaskFile::create([
                'task_id' => $task->id,
                'filename' => $request->file('pdf')->getClientOriginalName(),
                'path' => $path,
            ]);
        }

        Swal::success([
            'title' => 'Task "' . $incomingData['title'] . '" updated successfully.',
        ]);

        return redirect('dashboard')->with('success', 'Task "' . $incomingData['title'] . '" updated successfully.');
    }

    public function deleteTask(Task $task){
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        foreach ($task->fileRelation as $file) {
            if (Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }
            $file->delete();
        }

        // Delete the task
        $task->delete();

        return redirect('dashboard')->with('delete', 'Task "' . $task->title . '" deleted.');
    }

    public function deleteFile(TaskFile $file){
        if ($file->task->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        $file->delete();

        return redirect()->back()->with('delete', 'File "' . $file->filename . '" deleted.');
    }

    public function taskDetail(Task $task){
        if ($task->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        //to get the category details
        $task->load('category');

        //to get the user's categories
        $user = auth()->user();
        $query = $user->categoryRelation();
        $categories = $query->get();
        $query2 = $task->subtaskRelation();
        $subtasks = $query2->orderBy('id')->get();

        return view('taskDetail', [
            'task' => $task,
            'categories' => $categories,
            'subtasks' => $subtasks,
        ]);
    }
}
