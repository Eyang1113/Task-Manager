
    @php
        use Illuminate\Support\Carbon;
        use App\Models\Task;
    @endphp

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <form wire:submit.prevent="submit" class="space-y-6">
                    <h2 class="text-xl font-semibold mb-4">Add New Task</h2>
                    <div>
                        <label for="title" class="block text-sm font-medium">Title</label>
                        <input type="text" name="title" placeholder="Enter the title" wire:model="title" required
                               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium">Description</label>
                        <textarea name="description" placeholder="Enter the description" wire:model="description" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                        ></textarea>
                    </div>
                    <div>
                        <label for="due_date" class="block text-sm font-medium">Due Date</label>
                        <input type="datetime-local" name="due_date" wire:model="due_date" required min="{{ Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d\TH:i') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="pdf" class="block text-sm font-medium">File Upload (PDF)</label>
                        <input type="file" name="pdf" accept="application/pdf" wire:model="pdf"
                               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium">Category</label>
                        <select name="category" id="category" wire:model="category" required
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                            <option value="" disabled selected>Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <div class="flex gap-x-4">
                            <label class="inline-flex items-center space-x-1">
                                <input type="radio" name="status" wire:model="status" value="todo"
                                       class="text-blue-500 focus:ring-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-600">
                                <span>To Do</span>
                            </label>
                            <label class="inline-flex items-center space-x-1">
                                <input type="radio" name="status" wire:model="status" value="in_progress"
                                       class="text-blue-500 focus:ring-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-600">
                                <span>In Progress</span>
                            </label>
                            <label class="inline-flex items-center space-x-1">
                                <input type="radio" name="status" wire:model="status" value="done"
                                       class="text-blue-500 focus:ring-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-600">
                                <span>Done</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Task Priority</label>
                        <div class="flex gap-x-4">
                            <label class="inline-flex items-center space-x-1">
                                <input type="radio" name="priority" wire:model="priority" value="0"
                                       class="text-blue-500 focus:ring-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-600">
                                <span>Low</span>
                            </label>
                            <label class="inline-flex items-center space-x-1">
                                <input type="radio" name="priority" wire:model="priority" value="1"
                                       class="text-blue-500 focus:ring-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-600">
                                <span>Medium</span>
                            </label>
                            <label class="inline-flex items-center space-x-1">
                                <input type="radio" name="priority" wire:model="priority" value="2"
                                       class="text-blue-500 focus:ring-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-600">
                                <span>High</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow">
                            Add Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

