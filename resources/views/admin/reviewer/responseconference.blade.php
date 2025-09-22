@extends('admin.layout.layout')

@section('main-content')
    <div class="neo-card p-10 max-w-5xl mx-auto mt-12 bg-gray-100 shadow-md rounded-3xl overflow-x-auto">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-10">📝 Conference Paper Reviews</h2>

        <table class="min-w-full border text-sm">
            <thead class="bg-gray-200 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-2">Review ID</th>
                    <th class="px-4 py-2">Paper</th>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Reviewer1</th>
                    <th class="px-4 py-2">Reviewer2</th>
                    <th class="px-4 py-2">Reviewer3</th>
                    <th class="px-4 py-2">Evaluation</th>
                    <th class="px-4 py-2">Comments</th>
                    <th class="px-4 py-2">Payment</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($reviews as $index => $review)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-mono text-blue-600"> {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>

                        {{-- Show Paper Title --}}
                        <td class="px-6 py-2">
                            Paper-{{ $review->conferenceSubmission ? $review->conferenceSubmission->id : 'N/A' }}
                        </td>
                        {{-- <td class="px-4 py-2 text-center">{{ $submission->user->name ?? 'User ' . $submission->user_id }}
                        </td> --}}
                        <td class="px-4 py-2">
                            {{ $review->conferenceSubmission->user->name ?? 'User ' . $review->conferenceSubmission->user_id }}
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

                        {{-- <td class="px-4 py-2">
                            <div x-data="{ expanded: false }" x-cloak>
                                @php
                                    $allComments = json_decode($review->reviewer_comments, true) ?? [];
                                @endphp

                                @foreach ($allComments as $reviewerId => $data)
                                    <div class="mb-1">
                                        <strong>{{ App\Models\User::find($reviewerId)->name ?? 'Reviewer ' . $reviewerId }}:</strong>
                                        <span x-show="!expanded">{{ Str::limit($data['comment'], 50, '...') }}</span>
                                        <span x-show="expanded">{{ $data['comment'] }}</span>
                                        <em class="text-gray-500">({{ str_replace('_', ' ', $data['evaluation']) }})</em>
                                    </div>
                                @endforeach

                                @if (count($allComments) > 0)
                                    <button class="btn btn-sm btn-primary mt-2" @click="expanded = !expanded"
                                        x-text="expanded ? 'See Less' : 'See More'"></button>
                                @endif
                            </div>
                        </td> --}}

                        {{-- <td class="px-4 py-2">
                            <div x-data="{ expanded: false }" x-cloak>
                                <span x-show="!expanded">
                                    {{ Str::limit(\Illuminate\Support\Str::limit($review->reviewer_comments), 15, '...') }}
                                </span>
                                <span x-show="expanded">
                                    {{ \Illuminate\Support\Str::limit($review->reviewer_comments) }}
                                </span>
                                @if (strlen(\Illuminate\Support\Str::limit($review->reviewer_comments)) > 15)
                                    <button class="btn btn-sm btn-primary ms-2" @click="expanded = !expanded"
                                        x-text="expanded ? 'See Less' : 'See More'">
                                    </button>
                                @endif
                            </div>

                        </td> --}}
                        <td class="px-4 py-2">
                            <div x-data="{ expanded: false }" x-cloak>
                                {{-- @php
                                    $allComments = [];

                                    if (!empty($review->reviewer_comments)) {
                                        $decoded = json_decode($review->reviewer_comments, true);

                                        // ensure it's an array and each element is array too
    if (is_array($decoded)) {
        foreach ($decoded as $key => $value) {
            if (
                is_array($value) &&
                isset($value['comment'], $value['evaluation'])
                                                ) {
                                                    $allComments[$key] = $value;
                                                }
                                            }
                                        }
                                    }
                                @endphp --}}

                                {{-- @foreach ($allComments as $reviewerId => $data)
                                    <div class="mb-1">
                                        <strong>{{ App\Models\User::find($reviewerId)->name ?? 'Reviewer ' . $reviewerId }}:</strong>
                                        <span x-show="!expanded">{{ Str::limit($data['comment'], 10, '...') }}</span>
                                        <span x-show="expanded">{{ $data['comment'] }}</span>
                                        <em class="text-gray-500">({{ str_replace('_', ' ', $data['evaluation']) }})</em>
                                    </div>
                                @endforeach --}}

                                {{-- @php
                                    $allComments = json_decode($review->reviewer_comments, true) ?? [];
                                @endphp --}}

                                {{-- @foreach ($allComments as $commentData)
                                    <div class="mb-2">
                                        <span>{{ Str::limit($commentData['comment'], 150) }}</span>
                                        <em>({{ str_replace('_', ' ', $commentData['evaluation']) }})</em>
                                    </div>
                                @endforeach --}}


                                {{-- @if (count($allComments) > 0)
                                    <button class="btn btn-sm btn-primary mt-2" @click="expanded = !expanded"
                                        x-text="expanded ? 'See Less' : 'See More'"></button>
                                @endif --}}
                                {{-- @if (strlen($review->reviewer_comments) > 15)
                                    <button type="button" class="btn btn-sm btn-primary ms-2 mt-1"
                                        @click="expanded = !expanded" x-text="expanded ? 'See Less' : 'See More'">
                                    </button>
                                @endif --}}


                                @php
                                    $allComments = json_decode($review->reviewer_comments, true);
                                    if (!is_array($allComments)) {
                                        $allComments = [];
                                    }
                                @endphp

                                @foreach ($allComments as $commentData)
                                    @if (is_array($commentData))
                                        <div class="mb-2">
                                            <span>{{ Str::limit($commentData['comment'] ?? '', 150) }}</span>
                                            <em>({{ str_replace('_', ' ', $commentData['evaluation'] ?? '') }})</em>
                                        </div>
                                    @else
                                        <div class="mb-2">
                                            <span>{{ Str::limit($commentData, 150) }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if (
                                $review->conferenceSubmission &&
                                    $review->conferenceSubmission->kpay_image_path &&
                                    file_exists(storage_path('app/public/' . $review->conferenceSubmission->kpay_image_path)))
                                <a href="{{ asset('storage/' . $review->conferenceSubmission->kpay_image_path) }}"
                                    target="_blank">
                                    <img src="{{ asset('storage/' . $review->conferenceSubmission->kpay_image_path) }}"
                                        width="50px" height="50px" alt="KPay Receipt" class="px-2 py-1  rounded shadow">
                                </a>
                                <div class="mt-1">
                                    <a href="{{ asset('storage/' . $review->conferenceSubmission->kpay_image_path) }}"
                                        download
                                        class="inline-block px-2 py-1 bg-blue-500 text-black text-xs rounded hover:bg-blue-600">
                                        Download
                                    </a>
                                </div>
                            @else
                                <span class="text-gray-500">N/A</span>
                            @endif
                        </td>



                        <td class="px-6 py-2 text-center">
                            <!-- Edit Button -->
                            {{-- <a href="{{ route('reviewer.editConferenceReview', $review->id) }}"
                                class="inline-flex items-center px-1 py-1 bg-blue-500  rounded hover:bg-blue-600 transition text-sm">
                                <i class="fas fa-pen mr-1"></i>
                            </a> --}}

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
                                action="{{ route('admin.schedule.conferencetoggleStatus', $review->id) }}" method="POST"
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
                                action="{{ route('admin.schedule.conferencereturndestroy', $review->id) }}" method="POST"
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
<script src="//unpkg.com/alpinejs" defer></script>
