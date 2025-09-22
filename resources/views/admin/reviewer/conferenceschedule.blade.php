@extends('admin.layout.layout')

@section('main-content')
    <div
        class="neo-card p-10 max-w-5xl mx-auto mt-12 rounded-3xl bg-gray-100 shadow-[12px_12px_28px_#bebebe,-12px_-12px_28px_#ffffff]">

        <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-10 tracking-tight">
            📅 Create Conference Paper Review Schedule
        </h2>

        {{-- Topic & Paper Filter Form --}}
        <form method="GET" action="{{ route('admin.schedule.conference') }}"
            class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div>
                <label for="topic_id" class="block text-gray-700 font-semibold mb-2">Select Topic</label>
                <select style="margin-left:20px" id="topic_id" name="topic_id" onchange="this.form.submit()"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-1 shadow-inner focus:ring-2 focus:ring-blue-400 ">
                    <option value="">-- Choose Topic --</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}" {{ (int) ($topicId ?? 0) === $topic->id ? 'selected' : '' }}>
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
            </div><br>


        </form>

        {{-- Divider --}}
        <div class="border-t border-gray-300 my-8"></div>

        {{-- Schedule Submission Form --}}
        <form action="{{ route('admin.schedule.conferencestore') }}" method="POST" class="grid grid-cols-1 gap-8">
            @csrf

            {{-- <input type="hidden" name="conference_submission_id"
                value="{{ old('conference_submission_id', request('conference_submission_id')) }}"> --}}
            <div>
                <label for="conference_submission_id" class="block text-gray-700 font-semibold mb-2 ">Select
                    Paper</label>
                <select style="margin-left:18px" id="conference_submission_id" name="conference_submission_id"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-1 shadow-inner focus:ring-2 focus:ring-blue-400 transition">
                    <option value="">-- Choose Paper --</option>
                    @foreach ($papers as $paper)
                        <option value="{{ $paper->id }}">
                            {{-- {{ $paper->title ?? \Illuminate\Support\Str::of($paper->paper_path)->afterLast('/') }} --}}
                            {{ $paper->title ?? $paper->paper_original_name }}
                            {{-- {{ $paper->title ?? $paper->paper_original_name ?? $paper->paper_path ?? 'No Name Found' }} --}}
                        </option>
                    @endforeach
                </select>
            </div><br>
            {{-- Reviewers --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @for ($i = 1; $i <= 3; $i++)
                    <div>
                        <label for="reviewer{{ $i }}_id"
                            class="block text-gray-700 font-semibold mb-2 w-[150px]">Reviewer
                            {{ $i }}</label>
                        <select style="margin-left:28px" id="reviewer{{ $i }}_id"
                            name="reviewer{{ $i }}_id"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-1 shadow-inner focus:ring-2 focus:ring-blue-400 transition">
                            <option value="">-- Select Reviewer --</option>
                            @foreach ($reviewers as $rev)
                                <option value="{{ $rev->id }}">{{ $rev->name }}</option>
                            @endforeach
                        </select>
                    </div><br>
                @endfor
            </div>

            {{-- Date Fields --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-gray-700 font-semibold mb-2">Start Date</label>
                    <input style="margin-left:32px" type="date" id="start_date" name="start_date"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-1 shadow-inner focus:ring-2 focus:ring-blue-400 transition" />
                </div><br>

                <div>
                    <label for="end_date" class="block text-gray-700 font-semibold mb-2">End Date</label>
                    <input style="margin-left:40px" type="date" id="end_date" name="end_date"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-1 shadow-inner focus:ring-2 focus:ring-blue-400 transition" />
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="text-center pt-8">
                <button type="submit"
                    class="bg-gradient-to-r from-blue-500 to-indigo-600  font-bold py-2 px-20 rounded-full shadow-lg hover:from-blue-600 hover:to-indigo-700 active:scale-95 transition duration-200">
                    ✅ Save Schedule
                </button>
            </div>
        </form>
    </div>
@endsection
