@extends('admin.layout.layout')
@section('main-content')
    <div class="overflow-x-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Journal Submissions</h2>

        <table class="min-w-full border border-gray-300 shadow-lg rounded-lg overflow-hidden text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-2 text-left">Count</th>
                    <th class="px-4 py-2 text-left">User</th>
                    <th class="px-4 py-2 text-left">Topic</th>
                    <th class="px-4 py-2 text-left">Category</th>
                    <th class="px-4 py-2 text-left">Abstrat</th>
                    <th class="px-4 py-2 text-left">Keyword</th>
                    <th class="px-4 py-2 text-left">Paper</th>
                    <th class="px-4 py-2 text-left">Department Rule</th>
                    <th class="px-4 py-2 text-left">Professor Rule</th>
                    <th class="px-4 py-2 text-left">Start Date</th>
                    <th class="px-4 py-2 text-left">End Date</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($journalSubmissions as $index => $submission)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-mono text-blue-600 text-center">
                            {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-4 py-2 text-center">{{ $submission->user_id ?? 'User ' . $submission->user_id }}</td>
                        <td class="px-4 py-2 text-center">{{ $submission->topic_id ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $submission->category_id ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $submission->abstract ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $submission->keywords ?? '-' }}</td>
                        <!-- Paper -->
                        <td class="px-4 py-2 text-center">
                            @if ($submission->paper_path)
                                <a href="{{ route('admin.journalpaper.download', $submission->id) }}"
                                    class="text-green-600 underline hover:text-green-800" download>
                                    Download
                                </a>
                            @else
                                N/A
                            @endif
                        </td>

                        <!-- Department Rule -->
                        <td class="px-4 py-2 text-center">
                            @if ($submission->department_rule_path)
                                <a href="{{ route('admin.journaldprule.download', $submission->id) }}"
                                    class="text-green-600 underline hover:text-green-800" download>
                                    Download
                                </a>
                            @else
                                N/A
                            @endif
                        </td>

                        <!-- Professor Rule -->
                        <td class="px-4 py-2 text-center">
                            @if ($submission->professor_rule_path)
                                <a href="{{ route('admin.journalprorule.download', $submission->id) }}"
                                    class="text-green-600 underline hover:text-green-800" download>
                                    Download
                                </a>
                            @else
                                N/A
                            @endif
                        </td>

                        <td class="text-center">
                            {{ $submission->start_date ? $submission->start_date->format('d-m-Y') : '-' }}</td>
                        <td class="text-center">{{ $submission->end_date ? $submission->end_date->format('d-m-Y') : '-' }}
                        </td>
                        <td class="px-6 py-2 text-center">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.papers.journalsedit', $submission->id) }}"
                                class="inline-flex items-center px-1 py-1 bg-blue-500  rounded hover:bg-blue-600 transition text-sm">
                                <i class="fas fa-pen mr-1"></i>
                            </a>


                            <!-- Delete Button (uses JS to submit hidden form) -->
                            <a href="#"
                                onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this paper?')) { document.getElementById('delete-form-{{ $submission->id }}').submit(); }"
                                class="inline-flex items-center px-1 py-1 bg-red-500 text-danger  rounded hover:bg-red-600 transition text-sm">
                                <i class="fas fa-trash mr-1"></i>
                            </a>

                            <!-- Approach Button (uses JS to submit hidden form) -->


                            <!-- Hidden Delete Form -->
                            <form id="delete-form-{{ $submission->id }}"
                                action="{{ route('admin.papers.journalsdestroy', $submission->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>


                            <!-- Hidden Approach Form -->

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">No journal submissions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
