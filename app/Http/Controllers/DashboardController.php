<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function dashboardView(Request $request)
    {
        $user = auth()->user();
        $query = $user->taskRelation()->with('fileRelation', 'category');
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

    public function customCategory(){
        $user = auth()->user();
        $query = $user->categoryRelation();

        $categories = $query->get();

        return view('customCategory', [
            'categories' => $categories,
        ]);
    }

    public function createCategory(Request $request) {
        $incomingData = $request -> validate([
            'category_name' => ['required',
                Rule::unique('categories', 'category_name')->where('user_id', auth()->id())],
        ]);

        $incomingData['category_name'] = strip_tags($incomingData['category_name']);
        $incomingData['user_id'] = auth()->id();

        Category::create($incomingData);

        return redirect(route('customCategory'))->with('success', 'Category "' . $incomingData['category_name'] . '" created successfully.');
    }

    public function deleteCategory(Category $category) {
        if ($category->user_id !== auth()->id()) {
            return redirect('/dashboard');
        }

        $categoryCount = Category::where('user_id', auth()->id())->count();

        if ($categoryCount <= 1) {
            return redirect(route('customCategory'))->with('error', 'You must have at least one category.');
        }

        $category->delete();

        return redirect(route('customCategory'))->with('success', 'Category deleted.');
    }
}
