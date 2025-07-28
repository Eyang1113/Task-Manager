<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function dashboardView(Request $request)
    {
        $user = auth()->user();
        $query = $user->taskRelation()->with('fileRelation');

        $filter = $request->input('filter');

        // Apply filtering
        if (in_array($filter, ['todo', 'in_progress', 'done'])) {
            $query->where('status', $filter)
                ->orderby('priority', 'desc');
        } elseif ($filter === 'overdue') {
            $query->where('due_date', '<', Carbon::now('Asia/Kuala_Lumpur'))
                ->whereIn('status', ['todo', 'in_progress']);
        } elseif ($filter === 'due-date') {
            $query->orderBy('due_date', 'asc')
                ->orderby('priority', 'desc');
        } else {
            $query->orderby('priority', 'desc')
                ->orderBy('id', 'asc');
        }

        $tasks = $query->get();

        return view('dashboard', [
            'users' => $user,
            'tasks' => $tasks,
        ]);
    }
}
