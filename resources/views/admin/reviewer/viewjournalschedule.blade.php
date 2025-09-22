@extends('admin.layout.layout')

@section('main-content')
    <div
        class="neo-card p-10 max-w-5xl overflow-x-auto mx-auto mt-12 rounded-3xl bg-gray-100 shadow-[12px_12px_28px_#bebebe,-12px_-12px_28px_#ffffff]">

        <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-10 tracking-tight">
            📅Journal Review Schedule List
        </h2>

        <table class="min-w-full border border-gray-300 shadow-lg rounded-lg overflow-hidden text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-2 text-left">Schedule ID</th>
                    <th class="px-4 py-2 text-left">Paper</th>
                    <th class="px-4 py-2 text-left">Reviewer 1</th>
                    <th class="px-4 py-2 text-left">Reviewer 2</th>
                    <th class="px-4 py-2 text-left">Reviewer 3</th>
                    <th class="px-4 py-2 text-left">Start Date</th>
                    <th class="px-4 py-2 text-left">End Date</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($schedules as $index => $schedule)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-mono text-blue-600"> {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>

                        {{-- Show Paper Title --}}
                        <td class="px-4 py-2">
                            {{ $schedule->journalSubmission->id }}
                            {{-- {{ $schedule->journalSubmission->title ?? \Illuminate\Support\Str::of($schedule->journalSubmission->paper_path)->afterLast('/') }} --}}
                        </td>

                        {{-- Reviewer 1 --}}
                        <td class="px-4 py-2">{{ $schedule->reviewer1->name ?? 'N/A' }}</td>

                        {{-- Reviewer 2 --}}
                        <td class="px-4 py-2">{{ $schedule->reviewer2->name ?? 'N/A' }}</td>

                        {{-- Reviewer 3 --}}
                        <td class="px-4 py-2">{{ $schedule->reviewer3->name ?? 'N/A' }}</td>

                        {{-- Start Date --}}
                        <td class="px-4 py-2">{{ $schedule->start_date ?? '-' }}</td>

                        {{-- End Date --}}
                        <td class="px-4 py-2">{{ $schedule->end_date ?? '-' }}</td>
                        <td class="px-2 py-2 text-center">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.schedule.journaledit', $schedule->id) }}"
                                class="inline-flex items-center px-1 py-1 bg-blue-500  rounded hover:bg-blue-600 transition text-sm">
                                <i class="fas fa-pen mr-1"></i>
                            </a>
                            @if ($schedule->status === 'send')
                                {{-- Show Unsend Icon --}}
                                <a href="#"
                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to unsend this paper?')) { document.getElementById('unsend-form-{{ $schedule->id }}').submit(); }"
                                    class="inline-flex items-center px-1 py-1 bg-red-500  rounded hover:bg-red-600 transition text-sm ">
                                    <i class="fas fa-undo mr-1"></i> {{-- 🔁 Unsend icon --}}
                                </a>

                                <form id="unsend-form-{{ $schedule->id }}"
                                    action="{{ route('admin.schedule.journalsend', $schedule->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('PUT')
                                </form>
                            @else
                                {{-- Show Send Icon --}}
                                <a href="#"
                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to send this paper?')) { document.getElementById('send-form-{{ $schedule->id }}').submit(); }"
                                    class="inline-flex items-center px-1 py-1 bg-green-500  rounded hover:bg-green-600 transition text-sm">
                                    <i class="fas fa-paper-plane mr-1"></i> {{-- 📨 Send icon --}}
                                </a>

                                <form id="send-form-{{ $schedule->id }}"
                                    action="{{ route('admin.schedule.journalsend', $schedule->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('PUT')
                                </form>
                            @endif


                            <!-- Delete Button (uses JS to submit hidden form) -->
                            <a href="#"
                                onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this schedule?')) { document.getElementById('delete-form-{{ $schedule->id }}').submit(); }"
                                class="inline-flex items-center px-1 py-1 bg-red-500 text-danger  rounded hover:bg-red-600 transition text-sm">
                                <i class="fas fa-trash mr-1"></i>
                            </a>

                            <!-- Approach Button (uses JS to submit hidden form) -->


                            <!-- Hidden Delete Form -->
                            <form id="delete-form-{{ $schedule->id }}"
                                action="{{ route('admin.schedule.journaldestroy', $schedule->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <form id="send-form-{{ $schedule->id }}"
                                action="{{ route('admin.schedule.journalsend', $schedule->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('PUT')
                            </form>
                            <!-- Hidden Approach Form -->

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">No schedules found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endsection
