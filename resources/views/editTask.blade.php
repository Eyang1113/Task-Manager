@php
    use Illuminate\Support\Carbon;
    use App\Models\Task;
@endphp
<x-app-layout>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <form action="{{ route('update.task', ['task' => $task->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <h2 class="text-xl font-semibold mb-4">Edit Task</h2>
                    <div>
                        <label for="title" class="block text-sm font-medium">Title</label>
                        <input type="text" name="title" placeholder="Enter the title" required
                               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                               value="{{ $task->title }}">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium">Description</label>
                        <textarea name="description" placeholder="Enter the description" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                        >{{ $task->description }}</textarea>
                    </div>
                    <div>
                        <label for="pdf" class="block text-sm font-medium">File Upload (PDF)</label>
                        <input type="file" name="pdf" accept="application/pdf"
                               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                    </div>
                    @if(session('delete'))
                        <div class="bg-red-300 text-black px-4 py-2 rounded mb-4">
                            {{ session('delete') }}
                        </div>
                    @endif
                    @if($task->fileRelation->count())
                        <div class="mt-4 flex items-center flex-wrap gap-2">
                            <span class="block text-sm font-medium">File Attached:</span>
                            @foreach($task->fileRelation as $file)
                                <div class="flex items-center gap-1">
                                    <a href="{{ asset('storage/' . $file->path) }}"
                                       target="_blank"
                                       class="underline hover:text-blue-400 text-sm">
                                        {{ $file->filename }}
                                    </a>
                                    <a href="{{ route('delete.file', ['file' => $file->id]) }}">
                                        <img src="{{ asset('image/close.png') }}"
                                             alt="delete"
                                             class="w-4 h-4 cursor-pointer">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div>
                        <label for="due_date" class="block text-sm font-medium">Due Date</label>
                        <input type="datetime-local" name="due_date" required min="{{ Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d\TH:i') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                               value="{{ $task->due_date }}">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium">Category</label>
                        <select name="category" id="category" required
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                               {{ $task->category_id === $category->id ? 'selected' : ''}}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <div class="flex gap-x-4">
                            @foreach (Task::STATUS_OPTIONS as $value => $label)
                                <label class="inline-flex items-center space-x-1">
                                    <input type="radio" name="status" value="{{ $value }}"
                                           {{ $task->status === $value ? 'checked' : '' }}
                                           class="text-blue-500 focus:ring-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-600">
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Task Priority</label>
                        <div class="flex gap-x-4">
                            @foreach (Task::PRIORITY_OPTIONS as $value => $label)
                                <label class="inline-flex items-center space-x-1">
                                    <input type="radio" name="priority" value="{{ $value }}"
                                           {{ $task->priority == $value ? 'checked' : '' }}
                                           class="text-blue-500 focus:ring-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-600">
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow">
                            Update Task
                        </button>
                        <a href="{{ route('delete.task', ['task' => $task->id]) }}"
                           class="inline-block ml-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded shadow">
                            Delete
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
