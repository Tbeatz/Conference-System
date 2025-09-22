@extends('admin.layout.layout')

@section('main-content')
    <div class="neo-card p-10 max-w-5xl mx-auto mt-12 bg-gray-100 shadow-md rounded-3xl overflow-x-auto">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-10">📝 Journal Reviews</h2>

        <table class="min-w-full border text-sm">
            <thead class="bg-gray-200 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-2">Review ID</th>
                    <th class="px-4 py-2">Submission ID</th>
                    <th class="px-4 py-2">Reviewer1</th>
                    <th class="px-4 py-2">Reviewer2</th>
                    <th class="px-4 py-2">Reviewer3</th>
                    <th class="px-4 py-2">Evaluation</th>
                    <th class="px-4 py-2">Comments</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($reviews as $index => $review)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-mono text-blue-600"> {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>

                        {{-- Show Paper Title --}}
                        <td class="px-4 py-2">
                            {{ $review->journalSubmission ? $review->journalSubmission->id : 'N/A' }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $review->reviewer1->name ?? 'Unknown' }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $review->reviewer2->name ?? 'Unknown' }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $review->reviewer3->name ?? 'Unknown' }}
                        </td>
                        <td class="px-4 py-2 capitalize">
                            {{ str_replace('_', ' ', $review->evaluation) }}
                        </td>
                        <td class="px-4 py-2">
                            {{ \Illuminate\Support\Str::limit($review->reviewer_comments) }}
                        </td>
                        <td class="px-6 py-2 text-center">
                            <!-- Edit Button -->

                            @if ($review->status === 'sent')
                                <a href="#"
                                    onclick="event.preventDefault(); if(confirm('Unsend this review?')) { document.getElementById('toggle-status-{{ $review->id }}').submit(); }"
                                    class="inline-flex items-center px-1 py-1 bg-red-500 rounded hover:bg-red-600 text-sm ">
                                    <i class="fas fa-undo mr-1"></i>
                                @else
                                    <a href="#"
                                        onclick="event.preventDefault(); if(confirm('Send this review?')) { document.getElementById('toggle-status-{{ $review->id }}').submit(); }"
                                        class="inline-flex items-center px-1 py-1 bg-green-500 rounded hover:bg-green-600 text-sm ">
                                        <i class="fas fa-paper-plane mr-1"></i>
                                    </a>
                            @endif

                            <form id="toggle-status-{{ $review->id }}"
                                action="{{ route('admin.schedule.journaltoggleStatus', $review->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('PUT')
                            </form>




                            <!-- Delete Button (uses JS to submit hidden form) -->
                            <a href="#"
                                onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this schedule?')) { document.getElementById('delete-form-{{ $review->id }}').submit(); }"
                                class="inline-flex items-center px-1 py-1 bg-red-500 text-danger  rounded hover:bg-red-600 transition text-sm">
                                <i class="fas fa-trash mr-1"></i>
                            </a>

                            <!-- Approach Button (uses JS to submit hidden form) -->


                            <!-- Hidden Delete Form -->
                            <form id="delete-form-{{ $review->id }}"
                                action="{{ route('admin.schedule.journalreturndestroy', $review->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>


                            <!-- Hidden Approach Form -->

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">No reviews found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
