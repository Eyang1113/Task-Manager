<div>
    @php
        use Illuminate\Support\Carbon;
        use App\Models\Task;
    @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 space-y-6">
            @if(session('success'))
                <div class="bg-green-300 text-black px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @elseif(session('delete'))
                <div class="bg-red-300 text-black px-4 py-2 rounded">
                    {{ session('delete') }}
                </div>
            @endif
            <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md space-y-6">
                <h2 class="text-2xl font-semibold mb-4">Task Detail</h2>
                <div>
                    <label class="block text-lg font-medium">Title:</label>
                    <p class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                        {{ $task->title }}
                    </p>
                </div>
                <div>
                    <label class="block text-lg font-medium">Description:</label>
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
                    <label class="block text-lg font-medium">Due Date:</label>
                    <p class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                        {{ $task->due_date }}
                    </p>
                </div>
                <div>
                    <label class="block text-lg font-medium">Category:</label>
                    <p class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                        {{ $task->category->category_name }}
                    </p>
                </div>
                <div>
                    <label class="block text-lg font-medium">Status:</label>
                    <p class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                        {{ Task::STATUS_OPTIONS[$task->status] ?? $task->status }}
                    </p>
                </div>
                <div>
                    <label class="block text-lg font-medium">Task Priority:</label>
                    <p class="w-full px-2 py-2 rounded dark:bg-gray-900 border-none dark:text-white">
                        {{ Task::PRIORITY_OPTIONS[$task->priority] ?? $task->priority }}
                    </p>
                </div>
                <div>
                    <form method="POST" action="{{ route('update.subtask_status', ['task' => $task->id]) }}">
                        <label class="block text-lg font-medium mb-2">Subtasks:</label>
                        <div class="overflow-x-auto rounded-lg shadow">
                            <table class="min-w-full text-left text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 rounded-lg">
                                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
                                    <th class="px-4 py-2 text-sm font-medium border-b">Status</th>
                                    <th class="px-4 py-2 text-sm font-medium border-b">Title</th>
                                    <th class="px-4 py-2 text-sm font-medium border-b">Description</th>
                                    <th class="px-4 py-2 text-sm font-medium border-b" colspan="2">Action</th>
                                </tr>

                                @if($subtasks->count())
                                    @foreach($subtasks as $subtask)
                                        <tr class="border-b border-gray-300 dark:border-gray-600">
                                            <td class="px-4 py-2">
                                                <input type="checkbox" name="subtask[]" value="{{ $subtask->id }}"
                                                       {{ $subtask->is_done ? 'checked' : '' }}
                                                       class="form-checkbox h-5 w-5 text-blue-600 bg-gray-100 border-gray-300 rounded dark:bg-gray-800 dark:border-gray-600">
                                            </td>
                                            <td class="px-4 py-2 text-sm font-medium">{{ $subtask->title }}</td>
                                            <td class="px-4 py-2 text-sm font-medium">{{ $subtask->description }}</td>
                                            <td class="px-4 py-2 text-sm font-medium">
                                                <a href="/editSubtask(lw)/{{ $task->id }}/{{ $subtask->id }}" wire:navigate>
                                                    <img src="{{ asset('image/edit.png') }}" alt="edit" class="w-4 h-4 cursor-pointer invert">
                                                </a>
                                            </td>
                                            <td class="px-4 py-2 text-sm font-medium">
                                                <a href="#" wire:click="deleteSubtask({{ $subtask->id }})">
                                                    <img src="{{ asset('image/close.png') }}" alt="delete" class="w-4 h-4 cursor-pointer">
                                                </a>
                                                {{--                                            <button type="button" wire:click="deleteSubtask({{ $subtask->id }})" class="w-4 h-4">--}}
                                                {{--                                                <img src="{{ asset('image/close.png') }}" alt="delete" class="w-4 h-4 cursor-pointer">--}}
                                                {{--                                            </button>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="border-t border-gray-300 dark:border-gray-600">
                                        <td colspan="5" class="px-4 py-2 text-sm font-medium text-right">
                                            <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-1 rounded shadow transition">
                                                Update Subtask Status
                                            </button>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="5" class="px-4 py-2 italic text-left text-gray-500 dark:text-gray-300">
                                            No subtask found
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6">
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold">Add Subtask</h2>
                    <form wire:submit.prevent="addSubtask" class="mt-6 space-y-4">
                        <div>
                            <label class="block text-lg font-medium">Subtask Title: </label>
                            <input type="text" wire:model="subtaskTitle" wire:key="subtask-title-{{ now() }}" placeholder="Enter subtask title" required
                                   class="w-full px-4 py-2 border-none rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:text-white"/>
                        </div>
                        <div>
                            <label class="block text-lg font-medium">Description: </label>
                            <textarea wire:model="subtaskDescription" wire:key="subtask-desc-{{ now() }}" placeholder="Enter the description" required
                                      class="w-full px-4 py-2 border-none rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:text-white"></textarea>
                        </div>
                        <div>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow">
                                Add Subtask
                            </button>
                        </div>
                    </form>
                </div>

                @if ($errors->any())
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
