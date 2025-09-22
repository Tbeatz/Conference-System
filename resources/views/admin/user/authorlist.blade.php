@extends('admin.layout.layout')
@section('main-content')
    <div class="overflow-x-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Author List</h2>

        <table class="min-w-full border border-gray-300 shadow-lg rounded-lg overflow-hidden text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Position</th>
                    <th class="px-4 py-2 text-left">Department</th>
                    <th class="px-4 py-2 text-left">Organization</th>

                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($authors as $index => $author)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-mono text-blue-600">
                            {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-4 py-2">{{ $author->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $author->email ?? '-' }}</td>
                        <!-- Paper -->


                        <!-- Department Rule -->
                        <td class="px-4 py-2">
                            {{ $author->position ?? '-' }}
                        </td>

                        <!-- Professor Rule -->
                        <td class="px-4 py-2">
                            {{ $author->department ?? '-' }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $author->organization ?? '-' }}
                        </td>

                        <td class="px-2 py-2 text-center">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.user.edit', $author->id) }}"
                                class="inline-flex items-center px-1 py-1 bg-blue-500  rounded hover:bg-blue-600 transition text-sm">
                                <i class="fas fa-pen mr-1"></i>
                            </a>

                            <!-- Delete Button (uses JS to submit hidden form) -->
                            <a href="#"
                                onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this user?')) { document.getElementById('delete-form-{{ $author->id }}').submit(); }"
                                class="inline-flex items-center px-1 py-1 bg-red-500  rounded hover:bg-red-600 transition text-sm">
                                <i class="fas fa-trash mr-1"></i>
                            </a>

                            <!-- Approach Button (uses JS to submit hidden form) -->


                            <!-- Hidden Delete Form -->
                            <form id="delete-form-{{ $author->id }}"
                                action="{{ route('admin.user.destroy', $author->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <!-- Hidden Approach Form -->

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
