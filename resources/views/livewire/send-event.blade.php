<div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <h3 class="text-lg font-semibold text-gray-700 mb-3">Sent message to receive</h3>

    <div class="flex space-x-2">
        <input
            wire:model.blur="newMessage"
            type="text"
            placeholder="Type your message..."
            class="flex-1 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
        <button
            wire:click="sendMessage"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition"
        >
            Send
        </button>
        <button
            wire:click="resetMessage"
            class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition"
        >
            Reset
        </button>
    </div>
</div>
