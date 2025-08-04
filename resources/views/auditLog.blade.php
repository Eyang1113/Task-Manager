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
                            <tr class="border-b">
                                <th class="px-4 py-2">Task ID</th>
                                <th class="px-4 py-2">Commit Date</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Event</th>
                                <th class="px-4 py-2">Old Values</th>
                                <th class="px-4 py-2">New Values</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($audits as $audit)
                                @switch($audit->auditable_type)
                                    @case('App\Models\Task')
                                        <tr class="border-b border-gray-300 dark:border-gray-600">
                                            <td class="px-4 py-2">{{ $audit->auditable_id }}</td>
                                            <td class="px-4 py-2">{{ $audit->created_at }}</td>
                                            <td class="px-4 py-2">{{ $audit->auditable_type }}</td>
                                            <td class="px-4 py-2">{{ $audit->event }}</td>
                                            <td class="px-4 py-2">
                                                Title: {{ $audit->old_values['title'] ?? 'N/A' }}<br>
                                                Description: {{ $audit->old_values['description'] ?? 'N/A' }}<br>
                                                Due date: {{ $audit->old_values['due_date'] ?? 'N/A' }}<br>
                                                Category id: {{ $audit->old_values['category_id'] ?? 'N/A' }}<br>
                                                Status: {{ $audit->old_values['status'] ?? 'N/A' }}<br>
                                                Priority: {{ $audit->old_values['priority'] ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-2">
                                                Title: {{ $audit->new_values['title'] ?? 'N/A' }}<br>
                                                Description: {{ $audit->new_values['description'] ?? 'N/A' }}<br>
                                                Due date: {{ $audit->new_values['due_date'] ?? 'N/A' }}<br>
                                                Category id: {{ $audit->new_values['category_id'] ?? 'N/A' }}<br>
                                                Status: {{ $audit->new_values['status'] ?? 'N/A' }}<br>
                                                Priority: {{ $audit->new_values['priority'] ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        @break
                                    @case('App\Models\SubTask')
                                        <tr class="border-b border-gray-300 dark:border-gray-600">
                                            <td class="px-4 py-2">{{ $audit->auditable_id }}</td>
                                            <td class="px-4 py-2">{{ $audit->created_at }}</td>
                                            <td class="px-4 py-2">{{ $audit->auditable_type }}</td>
                                            <td class="px-4 py-2">{{ $audit->event }}</td>
                                            <td class="px-4 py-2">
                                                Title: {{ $audit->old_values['title'] ?? 'N/A' }}<br>
                                                Description: {{ $audit->old_values['description'] ?? 'N/A' }}<br>
                                                Task id: {{ $audit->old_values['task_id'] ?? 'N/A' }}<br>
                                            </td>
                                            <td class="px-4 py-2">
                                                Title: {{ $audit->new_values['title'] ?? 'N/A' }}<br>
                                                Description: {{ $audit->new_values['description'] ?? 'N/A' }}<br>
                                                Task id: {{ $audit->new_values['task_id'] ?? 'N/A' }}<br>
                                            </td>
                                        </tr>
                                        @break
                                    @case('App\Models\Category')
                                        <tr class="border-b border-gray-300 dark:border-gray-600">
                                            <td class="px-4 py-2">{{ $audit->auditable_id }}</td>
                                            <td class="px-4 py-2">{{ $audit->created_at }}</td>
                                            <td class="px-4 py-2">{{ $audit->auditable_type }}</td>
                                            <td class="px-4 py-2">{{ $audit->event }}</td>
                                            <td class="px-4 py-2">
                                                Category name: {{ $audit->old_values['category_name'] ?? 'N/A' }}<br>
                                                User id: {{ $audit->old_values['user_id'] ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-2">
                                                Category name: {{ $audit->new_values['category_name'] ?? 'N/A' }}<br>
                                                User id: {{ $audit->new_values['user_id'] ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        @break
                                @endswitch
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
