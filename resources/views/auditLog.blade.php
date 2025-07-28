@php
    use App\Models\Task;
@endphp
@include('sweetalert2::index')

<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl m-auto px-4 sm:px-6 lg:px-8">
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
                    <h1 class="text-3xl font-semibold pt-6 px-6 text-gray-900 dark:text-gray-100">Audit Log Table</h1>
                </div>
                <div class="text-gray-900 dark:text-gray-100">
                    <div class="p-6 overflow-x-auto">
                        <table class="min-w-full table-auto border border-gray-300 dark:border-gray-700 text-sm text-left text-gray-900 dark:text-gray-100">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                            <tr>
                                <th class="px-4 py-2 border-b">Task ID</th>
                                <th class="px-4 py-2 border-b">Event</th>
                                <th class="px-4 py-2 border-b">Commit Date</th>
                                <th class="px-4 py-2 border-b">Old Values</th>
                                <th class="px-4 py-2 border-b">New Values</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($audits as $audit)
                                <tr class="">
                                    <td class="px-4 py-2">{{ $audit->auditable_id }}</td>
                                    <td class="px-4 py-2">{{ $audit->event }}</td>
                                    <td class="px-4 py-2">{{ $audit->created_at }}</td>
                                    <td class="px-4 py-2">
                                        Title: {{ $audit->old_values['title'] ?? 'N/A' }}<br>
                                        Description: {{ $audit->old_values['description'] ?? 'N/A' }}<br>
                                        Status: {{ $audit->old_values['status'] ?? 'N/A' }}<br>
                                        Due date: {{ $audit->old_values['due_date'] ?? 'N/A' }}<br>
                                        Priority: {{ $audit->old_values['priority'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        Title: {{ $audit->new_values['title'] ?? 'N/A' }}<br>
                                        Description: {{ $audit->new_values['description'] ?? 'N/A' }}<br>
                                        Status: {{ $audit->new_values['status'] ?? 'N/A' }}<br>
                                        Due date: {{ $audit->new_values['due_date'] ?? 'N/A' }}<br>
                                        Priority: {{ $audit->new_values['priority'] ?? 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No audit logs found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
