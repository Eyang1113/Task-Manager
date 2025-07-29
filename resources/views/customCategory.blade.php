<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Custom Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-300 text-black px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="bg-red-300 text-black px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">View Categories</h2>
                    @forelse($categories as $category)
                        <div class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 py-2 px-2 rounded-md shadow-sm mt-2">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                    &bull; {{ $category->category_name }}
                                </h2>
                                <a href="{{ route('delete.category', ['category' => $category->id]) }}">
                                    <img src="{{ asset('image/close.png') }}"
                                         alt="delete"
                                         class="w-5 h-5 cursor-pointer">
                                </a>
                            </div>
                        </div>
                    @empty
                        <h2 class="text-gray-500 dark:text-gray-400 italic">No Category found.</h2>
                    @endforelse
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Add Category</h2>
                    <form method="POST" action="{{ route('create.category') }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <input type="text" name="category_name" placeholder="Enter a unique category name" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow">
                                Add Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
