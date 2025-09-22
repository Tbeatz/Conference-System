<div class="max-w-6xl mx-auto mt-10 space-y-6">
    <div class="bg-gradient-to-r from-green-100 to-blue-500 text-black p-6">
        <h2 class="text-xl font-semibold">Reviewer Paper Lists</h2>
    </div>
    {{-- @php
        print_r($conferencesubmissions);
    @endphp --}}
    @forelse($conferencesubmissions as $submission)
        <div x-data="{ showForm: false }" class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-200">

            <!-- Grid Row: Submission & Form -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <!-- ✅ Left: Submission Card (Clickable) -->
                <div @click="showForm = !showForm" class="cursor-pointer p-4 hover:bg-gray-50 transition">
                    <h3 class="text-lg font-bold text-blue-700 mb-1">
                        {{ $submission->conferenceSubmission->topics->name ?? 'Untitled' }}
                    </h3>

                    <p class="text-sm text-gray-600"><strong>Topic:</strong>
                        {{ $submission->conferenceSubmission->topics->name ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600"><strong>Category:</strong>
                        {{ $submission->conferenceSubmission->category->name ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600"><strong>Keywords:</strong>
                        {{ $submission->conferenceSubmission->keywords }}</p>
                    <p class="text-sm text-gray-500 mt-2"><strong>Abstract:</strong>
                        {{ Str::limit($submission->conferenceSubmission->abstract, 120) }}</p>

                    @if ($submission->conferenceSubmission->paper_path)
                        <div class="mt-2 text-left">
                            {{-- <a href="{{ route('admin.conference.download', $submission->id) }}"
                                class="inline-block px-1 py-1 bg-blue-400 text-white rounded-md hover:bg-blue-700 transition"
                                download {{ basename($submission->paper_path) }}>
                                Download Paper
                            </a> --}}
                            {{-- <a href="{{ route('admin.conference.download', $submission->id) }}"
                                class="inline-block px-1 py-1 bg-blue-400 text-white rounded-md hover:bg-blue-700 transition"
                                download="{{ basename($submission->conferenceSubmission->paper_path) }}">
                                Download Paper
                            </a> --}}

                            <a href="{{ route('admin.conference.download', $submission->conferenceSubmission->id) }}"
                                class="inline-block px-1 py-1 bg-blue-400 text-white rounded-md hover:bg-blue-700 transition"
                                download="{{ basename($submission->conferenceSubmission->paper_path) }}">
                                Download Paper
                            </a>

                        </div>
                    @endif


                    <p class="text-xs text-gray-400 mt-2">
                        Submitted on {{ $submission->created_at->format('M d, Y h:i A') }}
                    </p>

                    <p class="text-xs text-blue-500 italic mt-1">
                        <span x-text="showForm ? 'Click to hide form' : 'Click to review'"></span>
                        <noscript>Click to review</noscript>
                    </p>

                </div>

                <!-- ✅ Right: Review Form (Initially Hidden) -->
                <div x-show="showForm" x-transition class="border-l pl-4">
                    <form method="POST"
                        action="{{ route('conference.update', $submission->conferenceSubmission->id) }}"
                        enctype="multipart/form-data" class=" space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Please rate (✓) the paper on the following features:
                            </label>

                            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                                <table class="min-w-full text-sm text-center border-collapse">
                                    <thead class="bg-gray-100 text-gray-700">
                                        <tr>
                                            <th class="px-3 py-2 border">Item</th>
                                            <th class="px-3 py-2 border">Very Weak</th>
                                            <th class="px-3 py-2 border">Weak</th>
                                            <th class="px-3 py-2 border">Average</th>
                                            <th class="px-3 py-2 border">Strong</th>
                                            <th class="px-3 py-2 border">Very Strong</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600">
                                        @php
                                            $criteria = [
                                                'originality' => 'Originality',
                                                'significance' => 'Significance of the main idea(s)',
                                                'technical_quality' =>
                                                    'Technical Quality (experimental/technical/comparative results)',
                                                'familiarity' => "Reviewer's familiarity with the material",
                                                'related_work' => 'Awareness of related work',
                                                'clarity' => 'Clarity of presentation',
                                                'organization' => 'Organization of the paper',
                                                'length' => 'Paper Length',
                                                'relevance' =>
                                                    'Relevance of paper’s purpose, discussion and conclusion',
                                                'references' => 'Reference adequate and correctly cited',
                                            ];
                                            $scale = [
                                                '1' => 'Very Weak',
                                                '2' => 'Weak',
                                                '3' => 'Average',
                                                '4' => 'Strong',
                                                '5' => 'Very Strong',
                                            ];
                                        @endphp

                                        @foreach ($criteria as $key => $label)
                                            <tr class="border-t">
                                                <td class="px-3 py-2 border text-left font-medium">{{ $label }}
                                                </td>
                                                @foreach ($scale as $value => $desc)
                                                    <td class="px-3 py-2 border">
                                                        <input type="radio" name="ratings[{{ $key }}]"
                                                            value="{{ $value }}"
                                                            {{ old("ratings.$key") == $value ? 'checked' : '' }}
                                                            class="form-radio text-indigo-600">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Abstract --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Please rate (✓) the overall evaluation of the paper based on the following points:
                            </label>

                            <div class="w-full overflow-x-auto">
                                <div class="table w-full text-black table-fixed border">
                                    <div class="table-row">
                                        <label class="table-cell px-2 py-2 border text-sm">
                                            <input type="radio" name="evaluation" value="acceptable"
                                                {{ old('evaluation', $submission->evaluation ?? '') === 'acceptable' ? 'checked' : '' }}
                                                class="form-radio text-black mr-2">
                                            Acceptable
                                        </label>

                                        <label class="table-cell px-2 py-2 border text-black text-sm">
                                            <input type="radio" name="evaluation" value="minor_revisions"
                                                {{ old('evaluation', $submission->evaluation ?? '') === 'minor_revisions' ? 'checked' : '' }}
                                                class="form-radio text-black mr-2">
                                            Acceptable with minor revisions
                                        </label>

                                        <label class="table-cell px-2 py-2 border text-sm">
                                            <input type="radio" name="evaluation" value="major_revisions"
                                                {{ old('evaluation', $submission->evaluation ?? '') === 'major_revisions' ? 'checked' : '' }}
                                                class="form-radio text-indigo-600 mr-2">
                                            Acceptable with major revisions and revise
                                        </label>

                                        <label class="table-cell px-2 py-2 border text-sm">
                                            <input type="radio" name="evaluation" value="reject"
                                                {{ old('evaluation', $submission->evaluation ?? '') === 'reject' ? 'checked' : '' }}
                                                class="form-radio text-indigo-600 mr-2">
                                            Definite Reject
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="mb-4">
                            <label for="reviewer_comments" class="block text-sm font-medium text-gray-700 mb-2">
                                Reviewer’s Comments and Suggestions for the Author(s)
                            </label>
                            <p class="text-xs text-gray-500 mb-2">
                                Suggestions which would improve the quality of the paper. Please write 2 or 3 bullet
                                points below:
                            </p>

                            <textarea id="reviewer_comments" name="reviewer_comments" rows="6" required
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 text-black text-sm resize-y"
                                placeholder="• Suggestion one here...
• Suggestion two here...
• (Optional) Suggestion three...">{{ old('reviewer_comments', $submission->reviewer_comments ?? '') }}</textarea>
                        </div>



                        {{-- Submit --}}
                        <div class="text-right">
                            <button type="submit"
                                class="inline-block bg-gradient-to-r from-green-100 to-blue-200 text-black text-sm font-semibold px-3 py-2 rounded transition">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-200 text-gray-600 text-sm">
            You have not submitted any conferences yet.
        </div>
    @endforelse
</div>
