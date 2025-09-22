@extends('admin.layout.layout')
@section('main-content')
    <div class="overflow-x-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Conference Paper</h2>

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
                    <th class="px-4 py-2 text-left">Department Approval Letter</th>
                    <th class="px-4 py-2 text-left">University Recomemdation Letter</th>
                    <th class="px-4 py-2 text-left">Payment</th>
                    <th class="px-4 py-2 text-left">Payment Status</th>
                    <th class="px-4 py-2 text-left">Submission Date</th>
                    {{-- <th class="px-4 py-2 text-left">End Date</th> --}}
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($conferenceSubmissions as $index => $submission)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-mono text-blue-600 text-center">
                            {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-4 py-2 text-center">{{ $submission->user->name ?? 'User ' . $submission->user_id }}
                        </td>
                        <td class="px-6 py-2 text-center">
                            <div x-data="{ expanded: false }" x-cloak>
                                <span x-show="!expanded">
                                    {{ Str::limit($submission->topics->name, 25, '...') }}
                                </span>
                                <span x-show="expanded">
                                    {{ $submission->topics->name ?? '-' }}
                                </span>
                                @if (strlen($submission->topics->name) > 25)
                                    <button class="btn btn-sm btn-primary ms-2" @click="expanded = !expanded"
                                        x-text="expanded ? 'See Less' : 'See More'">
                                    </button>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-2 text-center">{{ $submission->category->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <div x-data="{ expanded: false }" x-cloak>
                                <span x-show="!expanded">
                                    {{ Str::limit($submission->abstract, 20, '...') }}
                                </span>
                                <span x-show="expanded">
                                    {{ $submission->abstract ?? '-' }}
                                </span>
                                @if (strlen($submission->abstract) > 20)
                                    <button class="btn btn-sm btn-primary ms-2" @click="expanded = !expanded"
                                        x-text="expanded ? 'See Less' : 'See More'">
                                    </button>
                                @endif
                            </div>
                        </td>

                        <td class="px-4 py-2">
                            <div x-data="{ expanded: false }" x-cloak>
                                <span x-show="!expanded">
                                    {{ Str::limit($submission->keywords, 10, '...') }}
                                </span>
                                <span x-show="expanded">
                                    {{ $submission->keywords ?? '-' }}
                                </span>
                                @if (strlen($submission->keywords) > 10)
                                    <button class="btn btn-sm btn-primary ms-2" @click="expanded = !expanded"
                                        x-text="expanded ? 'See Less' : 'See More'">
                                    </button>
                                @endif
                            </div>
                        </td>


                        <!-- Paper -->
                        <td class="px-4 py-2 text-center">
                            @if ($submission->paper_path)
                                <a href="{{ route('admin.conferencepaper.download', $submission->id) }}"
                                    class="text-green-600 underline hover:text-green-800" download>
                                    {{ basename($submission->paper_path) }}
                                    Download
                                </a>
                            @else
                                N/A
                            @endif
                        </td>

                        <!-- Department Rule -->
                        <td class="px-4 py-2 text-center">
                            @if ($submission->department_rule_path)
                                <a href="{{ route('admin.conferencedprule.download', $submission->id) }}"
                                    class="text-green-600 underline hover:text-green-800" download>
                                    {{ basename($submission->department_rule_path) }}
                                    Download
                                </a>
                            @else
                                N/A
                            @endif
                        </td>

                        <!-- Professor Rule -->
                        <td class="px-4 py-2 text-center">
                            @if ($submission->professor_rule_path)
                                {{-- <a href="{{ route('admin.conferenceprorule.download', $submission->id) }}" --}}
                                <a href="{{ route('admin.conferenceprorule.download', $submission->id) }}"
                                    class="text-green-600 underline hover:text-green-800" download>
                                    {{ basename($submission->professor_rule_path) }}
                                    Download
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if ($submission->kpay_image_path)
                                <a href="{{ asset('storage/' . $submission->kpay_image_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $submission->kpay_image_path) }}" alt="KPay Image"
                                        class="w-20 h-auto rounded-md border">
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="text-center">{{ ucfirst($submission->kpay_status ?? 'pending') }}</p>
                        </td>
                        <td class="text-center">
                            {{ $submission->created_at ? $submission->created_at->format('d-m-Y') : '-' }}</td>
                        {{-- <td class="text-center">
    {{ $paper->created_at ? $paper->created_at->format('d-m-Y') : '-' }}
</td> --}}
                        {{-- <td class="text-center">{{ $submission->end_date ? $submission->end_date->format('d-m-Y') : '-' }}
                        </td> --}}

                        <td class="px-6 py-2 text-center">
                            <!-- Edit Button -->
                            {{-- <a href="{{ route('admin.papers.conferencesedit', $submission->id) }}"
                                class="inline-flex items-center px-1 py-1 bg-blue-500  rounded hover:bg-blue-600 transition text-sm">
                                <i class="fas fa-pen mr-1"></i>
                            </a> --}}


                            <!-- Delete Button (uses JS to submit hidden form) -->
                            <a href="#"
                                onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this paper?')) { document.getElementById('delete-form-{{ $submission->id }}').submit(); }"
                                class="inline-flex items-center px-1 py-1 bg-red-500 text-danger  rounded hover:bg-red-600 transition text-sm">
                                <i class="fas fa-trash mr-1"></i>
                            </a>

                            <!-- Approach Button (uses JS to submit hidden form) -->


                            <!-- Hidden Delete Form -->
                            <form id="delete-form-{{ $submission->id }}"
                                action="{{ route('admin.papers.conferencesdestroy', $submission->id) }}" method="POST"
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
<script src="//unpkg.com/alpinejs" defer></script>
