@extends('admin.layout.layout')
@section('main-content')
    <div class="overflow-x-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Reviewer List</h2>

        <table class="min-w-full border border-gray-300 shadow-lg rounded-lg overflow-hidden text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Position</th>
                    <th class="px-4 py-2 text-left">Department</th>
                    <th class="px-4 py-2 text-left">Organization</th>
                    <th class="px-6 py-2 text-left">Field</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($reviewers as $index => $reviewer)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-mono text-blue-600">
                            {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-4 py-2">{{ $reviewer->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $reviewer->email ?? '-' }}</td>



                        <!-- Department Rule -->
                        <td class="px-4 py-2">
                            {{ $reviewer->position ?? '-' }}
                        </td>

                        <!-- Professor Rule -->
                        <td class="px-4 py-2">
                            {{ $reviewer->department ?? '-' }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $reviewer->organization ?? '-' }}
                        </td>
                        <td class="px-6 py-2 ">
                            {{ $reviewer->field ?? '-' }}
                        </td>
                        <td class="px-2 py-2">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.user.editreviewer', $reviewer->id) }}"
                                class="inline-flex items-center px-1 py-1 bg-blue-500  rounded hover:bg-blue-600 transition text-sm">
                                <i class="fas fa-pen mr-1"></i>
                            </a>

                            <!-- Delete Button (uses JS to submit hidden form) -->
                            <a href="#"
                                onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this user?')) { document.getElementById('delete-form-{{ $reviewer->id }}').submit(); }"
                                class="inline-flex items-center px-1 py-1 bg-red-500  rounded hover:bg-red-600 transition text-sm">
                                <i class="fas fa-trash mr-1"></i>
                            </a>

                            <!-- Approach Button (uses JS to submit hidden form) -->
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('approach-form-{{ $reviewer->id }}').submit();"
                                class="inline-flex items-center px-1 py-1 bg-green-500  rounded hover:bg-green-600 transition text-sm">

                                @if (isset($reviewer->email_verified_at))
                                    <i class="fas fa-times mr-1"></i>
                                @else
                                    <i class="fas fa-check-circle mr-1"></i>
                                @endif
                            </a>

                            <!-- Hidden Delete Form -->
                            <form id="delete-form-{{ $reviewer->id }}"
                                action="{{ route('admin.user.destroy', $reviewer->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <!-- Hidden Approach Form -->
                            <form id="approach-form-{{ $reviewer->id }}"
                                action="{{ route('admin.user.approach', $reviewer->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </td>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">No reviewer found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
