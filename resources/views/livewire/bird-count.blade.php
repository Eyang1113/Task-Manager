<div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6">
    <form wire:submit="submit" class="space-y-5">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Bird Count</label>
            <input
                type="number"
                wire:model="count"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Enter number of birds"
            />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea
                wire:model="notes"
                rows="3"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Write your notes here..."
            ></textarea>
        </div>
        <div>
            <button
                type="submit"
                class="w-full bg-indigo-600 text-white font-medium py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
            >
                Add a new bird count
            </button>
        </div>
    </form>

    @if ($errors->any())
        <div>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="mt-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Bird Counts</h2>
        <div class="space-y-3">
            @foreach($birds as $bird)
                <div wire:key="{{ $bird->id }}" wire:transition>
                    <div class="p-4 border rounded-md bg-gray-50 shadow-sm">
                        <p class="text-gray-800 font-medium">Count: {{ $bird->bird_count }}</p>
                        <p class="text-gray-600 text-sm mb-1">Notes: {{ $bird->notes }}</p>
                        <button
                            wire:click="delete({{ $bird->id }})"
                            class="w-full bg-indigo-600 text-white font-medium py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

