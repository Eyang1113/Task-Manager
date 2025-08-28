<div>
    @php
        use App\Models\Task;
    @endphp
    @include('sweetalert2::index')

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
            if (!dropdown.classList.contains('hidden')) {
                fetchReminderData();
            }
        }

        function fetchReminderData() {
            fetch("{{ route('reminder', ['reminder' => 'reminder']) }}")
                .then(response => response.json())
                .then(data => {
                    const countBadge = document.getElementById('reminderCountBadge');
                    const dropdown = document.getElementById('dropdown');

                    // Update reminder count badge
                    if (data.reminderCount > 0) {
                        countBadge.innerText = data.reminderCount;
                        countBadge.classList.remove('hidden');
                    } else {
                        countBadge.innerText = '';      // remove any leftover number
                        countBadge.classList.add('hidden'); // hide badge completely
                    }

                    // Clear and repopulate dropdown
                    dropdown.innerHTML = '';

                    if (data.tasks.length > 0) {
                        data.tasks.forEach(task => {
                            const taskElement = document.createElement('p');
                            taskElement.className = 'px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer';
                            taskElement.textContent = `Reminder: Task "${task.title}" due at ${task.due_date}`;
                            dropdown.appendChild(taskElement);
                        });
                    } else {
                        const empty = document.createElement('p');
                        empty.className = 'px-4 py-2 text-sm text-gray-500';
                        empty.textContent = 'No upcoming tasks.';
                        dropdown.appendChild(empty);
                    }
                })
                .catch(error => {
                    console.error('Reminder fetch failed:', error);
                });
        }

        // Run on initial load and when returning via back/forward
        window.addEventListener("pageshow", fetchReminderData);

        // Refresh reminders every 60 seconds
        setInterval(fetchReminderData, 60000);
    </script>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Task Manager') }}
            </h2>
            <div class="flex items-center space-x-4">
                <div class="relative cursor-pointer" onclick="toggleDropdown()">
                    <img src="{{ asset('image/bell.png') }}"
                         alt="notification"
                         class="w-7 h-7 invert cursor-pointer">
                    <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 text-black dark:text-white rounded shadow-lg border border-gray-300 z-50"></div>
                    <span id="reminderCountBadge"
                          class="hidden absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold w-5 h-5 rounded-full text-center leading-5">
                    </span>
                </div>
                <a href="/createTask(lw)" wire:navigate class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow">
                    Add Task
                </a>
            </div>
        </div>
    </x-slot>

    <div class="flex">
        <aside class="w-64 bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen p-10 rounded-lg shadow-md">
            <!--<h2 class="text-xl font-bold mb-4">Navigation</h2>-->
            <nav class="space-y-2">
                <div>
                    <label>
                        <p class="block px-3 py-2 rounded">Filter
                            <select wire:model.live="filter"
                                    class="block w-full px-3 py-2 rounded bg-white text-black dark:bg-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-700">
                                <option value="all">All</option>
                                <option value="todo">To Do</option>
                                <option value="in_progress">In Progress</option>
                                <option value="done">Done</option>
                                <option value="due-date">Due Date</option>
                                <option value="overdue">Overdue</option>
                            </select>
                        </p>
                    </label>

                    <label>
                        <p class="block px-3 py-2 rounded">Filter by category
                            <select wire:model.live="category_id"
                                    class="block w-full px-3 py-2 rounded bg-white text-black dark:bg-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-700">
                                <option value="0">All</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </p>
                    </label>
                </div>
            </nav>
        </aside>

        <div class="flex-1">
            <div class="py-10">
                <div class="max-w-7xl ml-14 px-4 sm:px-6 lg:px-8">
                    @if(session('success'))
                        <div class="bg-green-300 text-black px-4 py-2 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @elseif(session('delete'))
                        <div class="bg-red-300 text-black px-4 py-2 rounded mb-4">
                            {{ session('delete') }}
                        </div>
                    @endif
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="flex items-center justify-between">
                            <h1 class="text-3xl font-semibold pt-6 px-6 text-gray-900 dark:text-gray-100">Task Board</h1>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6 text-gray-900 dark:text-gray-100">
                            @forelse($tasks as $task)
                                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                                    <h2 class="text-xl font-extrabold mb-2">{{ $task->title }}</h2>
                                    <p class="text-sm font-semibold">Description: </p>
                                    <p class="text-sm mb-1 text-justify">{{ $task->description }}</p>
                                    <div>
                                        <p class="text-sm font-semibold">File Attached:
                                            @if($task->fileRelation->count())
                                                @foreach($task->fileRelation as $file)
                                                    <a href="{{ asset('storage/' . $file->path) }}"
                                                       target="_blank"
                                                       class="underline mr-2 hover:text-blue-400">
                                                        {{ $file->filename }}
                                                    </a>
                                                @endforeach
                                            @endif
                                        </p>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 pt-1 font-semibold">Due: {{ $task['due_date'] }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">
                                        Category: {{ $task->category->category_name}}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">
                                        Status: {{ Task::STATUS_OPTIONS[$task->status] ?? $task->status }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">
                                        Task Priority: {{ Task::PRIORITY_OPTIONS[$task->priority] ?? $task->priority }}
                                    </p>
                                    <div class="flex space-x-3 mt-4">
                                        <a href="/editTask(lw)/{{ $task->id }}" wire:navigate
                                           class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded shadow text-center transition">
                                            Edit
                                        </a>
                                        <a href="/taskDetail(lw)/{{ $task->id }}" wire:navigate
                                           class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded shadow text-center transition">
                                            More
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                                    <h2>No tasks found.</h2>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
