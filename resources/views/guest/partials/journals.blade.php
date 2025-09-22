<div class="max-w-6xl mx-auto mt-10 space-y-6">
    <div class="bg-blue-600 text-white p-6">
        <h2 class="text-xl font-semibold">My Assign List</h2>
    </div>
    @forelse($journalsubmissions as $submission)
        <div x-data="{ showForm: false }" class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-200">

            <!-- Grid Row: Submission & Form -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <!-- ✅ Left: Submission Card (Clickable) -->
                <div @click="showForm = !showForm" class="cursor-pointer">
                    <h3 class="text-lg font-bold text-blue-700 mb-1">
                        {{ $submission->journalSubmission->topics->name ?? 'Untitled' }}
                    </h3>

                    <p class="text-sm text-gray-600"><strong>Topic:</strong>
                        {{ $submission->journalSubmission->topics->name ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600"><strong>Category:</strong>
                        {{ $submission->journalSubmission->category->name ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600"><strong>Keywords:</strong>
                        {{ $submission->journalSubmission->keywords }}</p>
                    <p class="text-sm text-gray-500 mt-2"><strong>Abstract:</strong>
                        {{ Str::limit($submission->journalSubmission->abstract, 120) }}</p>

                    @if ($submission->journalSubmission->paper_path)
                        <p class="text-sm mt-2">
                            <strong>Paper:</strong>
                            <a href="{{ route('conference.download', $submission->id) }}"
                                class="text-blue-600 hover:underline hover:text-green-800" download>
                                Download
                            </a>
                        </p>
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
                    <form method="POST" action="{{ route('journals.update', $submission->journalSubmission->id) }}"
                        class=" space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- {{ dd($submission->journalSubmission->id) }} --}}

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
                                <div class="table w-full table-fixed border">
                                    <div class="table-row">
                                        <label class="table-cell px-2 py-2 border text-sm">
                                            <input type="radio" name="evaluation" value="acceptable"
                                                {{ old('evaluation', $submission->evaluation ?? '') === 'acceptable' ? 'checked' : '' }}
                                                class="form-radio text-indigo-600 mr-2">
                                            Acceptable
                                        </label>

                                        <label class="table-cell px-2 py-2 border text-sm">
                                            <input type="radio" name="evaluation" value="minor_revisions"
                                                {{ old('evaluation', $submission->evaluation ?? '') === 'minor_revisions' ? 'checked' : '' }}
                                                class="form-radio text-indigo-600 mr-2">
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
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm resize-y"
                                placeholder="• Suggestion one here...
• Suggestion two here...
• (Optional) Suggestion three...">{{ old('reviewer_comments', $submission->reviewer_comments ?? '') }}</textarea>
                        </div>



                        {{-- Submit --}}
                        <div class="text-right">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                                Submit Journal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-200 text-gray-600 text-sm">
            You have not submitted any journals yet.
        </div>
    @endforelse
</div>
