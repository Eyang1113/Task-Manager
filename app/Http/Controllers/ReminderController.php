<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReminderController extends Controller
{
    public function getTask(Request $request){
        $user = auth()->user();
        $reminder = $request->input('reminder');
        $reminderCount = 0;

        $query = $user->taskRelation()->with('fileRelation');
        //dd($query);

        if ($reminder === 'reminder') {
            // Define the 30-minute window
            $now = Carbon::now('Asia/Kuala_Lumpur');
            $next30 = $now->copy()->addMinutes(60);

            // Count tasks that match the "reminder" condition
            $reminderCount = $user->taskRelation()
                ->whereBetween('due_date', [$now, $next30])
                ->where('reminded', false)
                ->count();
            //dd($reminderCount);

            // Limit tasks to only the ones that meet the condition
            $query->whereBetween('due_date', [$now, $next30])
                ->where('reminded', false);

            // Update overdue tasks
            $user->taskRelation()
                ->where('due_date', '<=', $now)
                ->where('reminded', false)
                ->update(['reminded' => true]);
        }

        // Get tasks (filtered only if "reminder" is passed)
        $tasks = $query->get();

        return [
            'users' => $user,
            'tasks' => $tasks,
            'reminderCount' => $reminderCount
        ];
    }
}
