@extends('admin.layout.layout')

@section('main-content')
    <div class="container mt-10 max-w-3xl mx-auto neo-card p-8 rounded-2xl bg-gray-50">
        <h2 class="text-2xl font-bold mb-6 text-center">✏️ Edit Journal Review Schedule</h2>

        <form method="POST" action="{{ route('admin.schedule.journalupdate', $schedules->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="journal_submission_id" class="block text-gray-700 font-semibold mb-2 ">
                        Paper</label><br>
                    <input type="text" name="current_paper" style="width:100%" readonly
                        value="{{ $schedules->journalSubmission->title ??
                            \Illuminate\Support\Str::of($schedules->journalSubmission->paper_path)->afterLast('/') }}"
                        class="form-input w-full px-4 py-1 mb-2 rounded bg-gray-100 border">
                </div><br>
                <div>
                    <label for="journal_submission_id" class="block text-gray-700 font-semibold mb-2 ">
                        Upload New Paper</label><br>
                    <!-- Upload new paper -->
                    <input type="file" name="paper" class="form-input w-[400px] px-4 py-1 rounded border"
                        accept=".pdf,.doc,.docx,.txt" style="width:100%">
                </div><br>

                <!-- Reviewer 1 -->
                <div>
                    <label class="block font-semibold mb-1">Reviewer 1</label>
                    <select name="reviewer1_id" class="form-select w-full rounded p-2">
                        <option value="">-- Select Reviewer --</option>
                        @foreach ($reviewers as $reviewer)
                            <option value="{{ $reviewer->id }}"
                                {{ $schedules->reviewer1_id == $reviewer->id ? 'selected' : '' }}>
                                {{ $reviewer->name }}
                            </option>
                        @endforeach
                    </select>
                </div><br>

                <!-- Reviewer 2 -->
                <div>
                    <label class="block font-semibold mb-1">Reviewer 2</label>
                    <select name="reviewer2_id" class="form-select w-full rounded p-2">
                        <option value="">-- Select Reviewer --</option>
                        @foreach ($reviewers as $reviewer)
                            <option value="{{ $reviewer->id }}"
                                {{ $schedules->reviewer2_id == $reviewer->id ? 'selected' : '' }}>
                                {{ $reviewer->name }}
                            </option>
                        @endforeach
                    </select>
                </div><br>

                <!-- Reviewer 3 -->
                <div>
                    <label class="block font-semibold mb-1">Reviewer 3</label>
                    <select name="reviewer3_id" class="form-select w-full rounded p-2">
                        <option value="">-- Select Reviewer --</option>
                        @foreach ($reviewers as $reviewer)
                            <option value="{{ $reviewer->id }}"
                                {{ $schedules->reviewer3_id == $reviewer->id ? 'selected' : '' }}>
                                {{ $reviewer->name }}
                            </option>
                        @endforeach
                    </select>
                </div><br>

                <!-- Start Date -->
                <div>
                    <label class="block font-semibold mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ $schedules->start_date }}"
                        class="form-input w-full rounded p-2 border">
                </div><br>

                <!-- End Date -->
                <div>
                    <label class="block font-semibold mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ $schedules->end_date }}"
                        class="form-input w-full rounded p-2 border">
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="bg-blue-600  px-12 py-2 rounded shadow hover:bg-blue-700">
                    Update Schedule
                </button>
            </div>
        </form>
    </div>
@endsection
