<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function dashboardView(Request $request){
        $user = auth()->user();
        $query = $user->taskRelation()->with('fileRelation', 'category');
        $filter = $request->input('filter');
        $categoryId = $request->input('category_id');

        if ($categoryId != 0) {
            $query->where('category_id', $categoryId);
        }

        switch ($filter) {
            case 'todo':
            case 'in_progress':
            case 'done':
                $query->where('status', $filter)
                    ->orderBy('priority', 'desc');
                break;
            case 'overdue':
                $query->where('due_date', '<', Carbon::now('Asia/Kuala_Lumpur'))
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

        $tasks = $query->get();
        $categories = $user->categoryRelation()->get();

        return view('dashboard', [
            'users' => $user,
            'tasks' => $tasks,
            'categories' => $categories,
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
            'category_name' => ['required', Rule::unique('categories', 'category_name')->where('user_id', auth()->id())],
        ]);

        $incomingData['category_name'] = strip_tags($incomingData['category_name']);
        $incomingData['user_id'] = auth()->id();

        Category::create($incomingData);

        return redirect(route('customCategory'))->with('success', 'Category "' . $incomingData['category_name'] . '" created successfully.');
    }

    public function deleteCategory(Category $category) {
        if ($category->user_id !== auth()->id()) {
            return redirect('dashboard');
        }

        $categoryCount = Category::where('user_id', auth()->id())->count();

        if ($categoryCount <= 1) {
            return redirect(route('customCategory'))->with('error', 'You must have at least one category.');
        }

        $category->delete();

        return redirect(route('customCategory'))->with('delete', 'Category "' . $category->category_name . '" deleted.');
    }
}
