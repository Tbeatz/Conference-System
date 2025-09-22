@extends('admin.layout.layout')

@section('main-content')
<div class="neo-card p-10 max-w-5xl mx-auto mt-12 bg-gray-100 shadow-md rounded-3xl overflow-x-auto">
    <h2 class="text-4xl font-bold text-center text-gray-800 mb-10">✏️ Edit Conference Evaluation</h2>

    <form action="{{ route('reviewer.updateConference', $schedule->conferenceSubmission->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Paper:</label>
            <span class="text-gray-900 font-mono">Paper-{{ $schedule->conferenceSubmission->id }}</span>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Current Evaluation:</label>
            <select name="evaluation" class="border rounded px-3 py-2 w-full">
                <option value="acceptable" {{ $currentEvaluation === 'acceptable' ? 'selected' : '' }}>Acceptable</option>
                <option value="minor_revisions" {{ $currentEvaluation === 'minor_revisions' ? 'selected' : '' }}>Minor Revisions</option>
                <option value="major_revisions" {{ $currentEvaluation === 'major_revisions' ? 'selected' : '' }}>Major Revisions</option>
                <option value="reject" {{ $currentEvaluation === 'reject' ? 'selected' : '' }}>Reject</option>
            </select>
            @error('evaluation')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Reviewer Comments:</label>
            <textarea name="reviewer_comments" class="border rounded px-3 py-2 w-full" rows="5" required>{{ old('reviewer_comments', $schedule->conferenceSubmission->conferenceReview->reviewer_comments ?? '') }}</textarea>
            @error('reviewer_comments')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-5 py-2 rounded">
                Save Evaluation
            </button>
        </div>
    </form>
</div>
@endsection
