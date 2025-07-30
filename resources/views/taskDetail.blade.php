@php
    use Illuminate\Support\Carbon;
    use App\Models\Task;
@endphp
<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 space-y-6">
            @if(session('success'))
                <div class="bg-green-300 text-black px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @elseif(session('delete'))
                <div class="bg-red-300 text-black px-4 py-2 rounded mb-4">
                    {{ session('delete') }}
                </div>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold mb-4">Add Subtask</h2>
                    <form method="POST" action="{{ route('create.subtask', ['task' => $task->id]) }}"
                          class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <input type="text" name="title" placeholder="Enter subtask title" required
                                   class="w-full px-4 py-2 rounded border-none focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow">
                                Add Subtask
                            </button>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold mb-4">View Subtasks</h2>
                    <form method="POST" action="{{ route('update.subtask', ['task' => $task->id]) }}">
                        @csrf
                        @method('PUT')
                        @if($subtasks->count())
                            <div class="grid grid-flow-col grid-cols-3 grid-rows-5 gap-y-3 gap-x-6">
                                @foreach($subtasks as $subtask)
                                    <label
                                        class="flex items-center space-x-3 text-gray-900 dark:text-white cursor-pointer">
                                        <input
                                            type="checkbox"
                                            name="subtask[]"
                                            value="{{ $subtask->id }}"
                                            {{ $subtask->is_done ? 'checked' : '' }}
                                            class="form-checkbox h-5 w-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:focus:ring-blue-400 dark:ring-offset-gray-800"
                                        >
                                        <span class="text-base">{{ $subtask->title }}</span>
                                        <a href="{{ route('delete.subtask', ['task' => $task->id, 'subtask' => $subtask->id]) }}">
                                            <img src="{{ asset('image/close.png') }}"
                                                 alt="delete"
                                                 class="w-5 h-5 cursor-pointer">
                                        </a>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <h2 class="text-gray-500 dark:text-gray-400 italic">No Subtask found.</h2>
                        @endif

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow transition">
                                Update Subtask Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <div class="space-y-6">
                    <h2 class="text-2xl font-semibold mb-4">Task Detail</h2>
                    <div>
                        <label for="title" class="block text-lg font-medium">Title: </label>
                        <p class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                            {{ $task->title }}
                        </p>
                    </div>
                    <div>
                        <label for="description" class="block text-lg font-medium">Description: </label>
                        <p class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                            {{ $task->description }}
                        </p>
                    </div>
                    @if($task->fileRelation->count())
                        <div class="mt-4 flex items-center flex-wrap">
                            <span class="block text-lg font-medium">File Attached:</span>
                            <div class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                                @foreach($task->fileRelation as $file)
                                        <a href="{{ asset('storage/' . $file->path) }}"
                                           target="_blank"
                                           class="underline hover:text-blue-400 text-lg font-medium">
                                            {{ $file->filename }}
                                        </a><br>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div>
                        <label for="due_date" class="block text-lg font-medium">Due Date: </label>
                        <p class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                            {{ $task->due_date }}
                        </p>
                    </div>
                    <div>
                        <label for="category" class="block text-lg font-medium">Category: </label>
                        <p class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                            {{$task->category->category_name}}
                        </p>
                    </div>
                    <div>
                        <label class="block text-lg font-medium">Status: </label>
                        <p class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                            {{ Task::STATUS_OPTIONS[$task->status] ?? $task->status }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-lg font-medium">Task Priority: </label>
                        <p class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                            {{ Task::PRIORITY_OPTIONS[$task->priority] ?? $task->priority }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
