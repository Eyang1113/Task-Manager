<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Subtask') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Edit Subtask</h2>
                    <form wire:submit.prevent="update" class="mt-6 space-y-6">
                        <div>
                            <input type="text" name="title" placeholder="Enter subtask title" wire:model="title" required
                                   class="w-full px-4 py-2 rounded border-none focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:text-white"
                            >
                        </div>
                        <div>
                            <textarea name="description" placeholder="Enter the description" wire:model="description" required
                                      class="w-full px-4 py-2 border-none rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:text-white"
                            ></textarea>
                        </div>
                        <div>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow">
                                Update Subtask
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
