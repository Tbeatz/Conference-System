@extends('admin.layout.layout')

@section('main-content')
    <div class="container mt-10 max-w-3xl mx-auto neo-card p-8 rounded-2xl bg-gray-50">
        <h2 class="text-2xl font-bold mb-6 text-center">✏️ Edit Conference Paper</h2>

        <form method="POST" action="{{ route('admin.papers.conferenceupdate', $submission->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="list-disc list-inside text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Name --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Name</label>
                <input type="text" name="name" class="form-control w-full rounded px-3 py-2"
                    value="{{ old('name', $submission->user->name) }}" required>
            </div>

            {{-- Topic --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Topic</label>
                <select name="topic_id" class="form-select w-full rounded p-2">
                    <option value="">-- Select Topic --</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}"
                            {{ old('topic_id', $submission->topic_id) == $topic->id ? 'selected' : '' }}>
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Abstract --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Abstract</label><br>
                <textarea name="abstract" class="form-textarea w-full rounded p-2" rows="4" required>{{ old('abstract', $submission->abstract) }}</textarea>
            </div>

            {{-- Keywords --}}
            <div class="mb-4">
                <label for="keywords" class="block font-medium text-gray-700">Keywords</label>
                <input type="text" name="keywords" id="keywords" class="w-full border rounded px-3 py-2"
                    placeholder="Enter Keyword" required maxlength="255">
            </div>




            {{-- Start & End Date --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Start Date</label><br>
                    <input type="date" name="start_date" class="form-textarea w-full rounded p-2"
                        value="{{ old('start_date', $submission->start_date) }}" required>
                </div><br>
                <div>
                    <label class="block font-semibold mb-1">End Date</label><br>
                    <input type="date" name="end_date" class="form-input w-full rounded p-2"
                        value="{{ old('end_date', $submission->end_date) }}" required>
                </div>
            </div>

            {{-- Paper Upload --}}
            <div class="mt-4">
                {{-- <p class="text-sm mt-1 ">Current:<span class="text-primary">
                        {{ $submission->title ?? \Illuminate\Support\Str::of($submission->paper_path)->afterLast('/') }}</span>
                </p> --}}
                <label class="block font-semibold mb-1">Upload New Paper</label><br>
                <input type="file" name="paper" class="form-input w-full px-4 py-2 rounded border"
                    accept=".pdf,.doc,.docx">
                @if ($submission->paper_path)
                @endif
            </div>

            {{-- Department Rule --}}
            <div class="mt-4">
                {{-- <p class="text-sm mt-1 ">Current:<span class="text-primary">
                        {{ $submission->title ?? \Illuminate\Support\Str::of($submission->department_rule_path)->afterLast('/') }}</span>
                </p> --}}
                <label class="block font-semibold mb-1">Department Approval Letter</label><br>
                <input type="file" name="department_rule_file" class="form-input w-full px-4 py-2 rounded border"
                    accept=".pdf,.doc,.docx">
                {{-- @if ($submission->department_rule_path)
                    <p class="text-sm mt-1">Current: <a href="{{ asset('storage/' . $submission->department_rule_path) }}"
                            target="_blank" class="text-blue-600 underline">View File</a></p>
                @endif --}}
            </div>

            {{-- Professor Rule --}}
            <div class="mt-4">
                {{-- <p class="text-sm mt-1 ">Current:<span class="text-primary">
                        {{ $submission->title ?? \Illuminate\Support\Str::of($submission->professor_rule_path)->afterLast('/') }}</span>
                </p> --}}
                <label class="block font-semibold mb-1">University Recomemdation Letter</label><br>
                <input type="file" name="professor_rule_file" class="form-input w-full px-4 py-2 rounded border"
                    accept=".pdf,.doc,.docx">
                {{-- @if ($submission->professor_rule_path)
                    <p class="text-sm mt-1">Current: <a href="{{ asset('storage/' . $submission->professor_rule_path) }}"
                            target="_blank" class="text-blue-600 underline">View File</a></p>
                @endif --}}
            </div><br>

            {{-- Submit --}}
            <div class="text-center mt-6">
                <button type="submit" class="bg-blue-600  px-6 py-2 rounded shadow hover:bg-blue-700 transition">
                    Update Paper
                </button>
            </div>
        </form>
    </div>
@endsection
