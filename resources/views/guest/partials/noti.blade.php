{{-- Preparation --}}
@if ($section === 'noti')
    <div
        class="author-notifications p-4 bg-gradient-to-r from-green-100 to-blue-500 text-black rounded shadow max-w-md mx-auto">

        <h2 class="text-xl font-semibold mb-4">Your Notifications</h2>


        @if ($notifications->count() > 0)
            <ul class="space-y-3">
                @foreach ($notifications as $notification)
                    <li class="border p-3 rounded bg-blue-50 flex justify-between items-center">
                        <div>
                            <p class="text-gray-800" style="text-align: justify;">{{ $notification->data['message'] }}</p>
                            @if (isset($notification->data['evaluation']) &&
                                    in_array($notification->data['evaluation'], ['major_revisions', 'minor_revisions']))
                                <div x-data="{
                                    show: false,
                                    submissionId: null,
                                    category: '',
                                    openModal(id, cat) {
                                        this.submissionId = id;
                                        this.category = cat;
                                        this.show = true;
                                    }
                                }" x-cloak>

                                    <!-- Trigger Button -->
                                    <button
                                        @click="openModal({{ $notification->data['submission_id'] }}, '{{ $notification->data['category'] }}')"
                                        class="inline-block bg-gradient-to-r from-green-100 to-blue-200 text-black text-sm font-semibold px-3 py-2 rounded transition">
                                        Edit Paper
                                    </button>
                                    {{-- <button
                                    @click="openModal({{ $notification->data['submission_id'] }}, '{{ addslashes($notification->data['category']) }}')"
                                         class="inline-block bg-gradient-to-r from-green-100 to-blue-200 text-black text-sm font-semibold px-3 py-2 rounded transition">
                                        Edit Paper
                                    </button> --}}


                                    <!-- Modal Overlay -->
                                    <div x-show="show" class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                        @click="show = false"></div>

                                    <!-- Modal -->
                                    <div x-show="show" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                                        <div @click.away="show = false"
                                            class="bg-white rounded-lg shadow-lg overflow-y-auto max-h-[90vh] max-w-2xl w-full p-6">
                                            <h2 class="text-xl font-semibold mb-4 text-gray-700">Edit Your Paper</h2>

                                            <!-- FORM LOGIC -->
                                            <template x-if="category === 'conference'">
                                                <form method="POST" :action="`/conference/${submissionId}`"
                                                    class="space-y-4" enctype="multipart/form-data" class="space-y-4">
                                                    @csrf
                                                    @method('PUT')
                                                    @if ($errors->any())
                                                        <div>
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li class="text-red-500">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif




                                                    <div>
                                                        <label for="abstract"
                                                            class="block font-medium text-gray-700">Abstract</label>
                                                        <textarea name="abstract" id="abstract" rows="4" class="w-full border rounded px-3 py-2"
                                                            placeholder="Enter abstract" required></textarea>
                                                    </div>

                                                    <div>
                                                        <label for="keywords"
                                                            class="block font-medium text-gray-700">Keywords</label>
                                                        <input type="text" name="keywords" id="keywords"
                                                            class="w-full border rounded px-3 py-2"
                                                            placeholder="Enter Keyword" required maxlength="255">
                                                    </div><br><br>
                                                    <div>
                                                        <label for="paper"
                                                            class="block font-medium text-gray-700">Paper
                                                            (PDF, DOC, DOCX)
                                                        </label>
                                                        <input type="file" name="paper" id="paper"
                                                            accept=".pdf,.doc,.docx"
                                                            class="w-full border rounded px-3 py-2">
                                                    </div>

                                                    <div>
                                                        <label for="department_rule_file"
                                                            class="block font-medium text-gray-700">Department
                                                            Approvement
                                                            (PDF,
                                                            DOC, DOCX)
                                                        </label>
                                                        <input type="file" name="department_rule_file"
                                                            id="department_rule_file" accept=".pdf,.doc,.docx"
                                                            class="w-full border rounded px-3 py-2">
                                                    </div>

                                                    <div>
                                                        <label for="professor_rule_file"
                                                            class="block font-medium text-gray-700">University
                                                            Recommendation
                                                            (PDF,
                                                            DOC, DOCX)</label>
                                                        <input type="file" name="professor_rule_file"
                                                            id="professor_rule_file" accept=".pdf,.doc,.docx"
                                                            class="w-full border rounded px-3 py-2">
                                                    </div>

                                                    <div class="text-right">
                                                        <button type="submit"
                                                            class="inline-block bg-gradient-to-r from-green-100 to-blue-200 text-black text-sm font-semibold px-3 py-2 rounded transition">
                                                            Update Paper
                                                        </button>
                                                    </div>

                                                </form>
                                            </template>

                                            <template x-if="category === 'journal'">
                                                <form method="POST" :action="`/journal/${submissionId}`"
                                                    class="space-y-4" enctype="multipart/form-data" class="space-y-4">
                                                    @csrf
                                                    @method('PUT')
                                                    @if ($errors->any())
                                                        <div>
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li class="text-red-500">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif




                                                    <div>
                                                        <label for="abstract"
                                                            class="block font-medium text-gray-700">Abstract</label>
                                                        <textarea name="abstract" id="abstract" rows="4" class="w-full border rounded px-3 py-2"
                                                            placeholder="Enter abstract" required></textarea>
                                                    </div>

                                                    <div>
                                                        <label for="keywords"
                                                            class="block font-medium text-gray-700">Keywords</label>
                                                        <input type="text" name="keywords" id="keywords"
                                                            class="w-full border rounded px-3 py-2"
                                                            placeholder="Enter Keyword" required maxlength="255">
                                                    </div><br><br>

                                                    <div>
                                                        <label for="paper"
                                                            class="block font-medium text-gray-700">Paper
                                                            (PDF, DOC, DOCX)
                                                        </label>
                                                        <input type="file" name="paper" id="paper"
                                                            accept=".pdf,.doc,.docx"
                                                            class="w-full border rounded px-3 py-2">
                                                    </div>

                                                    <div>
                                                        <label for="department_rule_file"
                                                            class="block font-medium text-gray-700">Department Approval
                                                            (PDF,
                                                            DOC, DOCX)
                                                        </label>
                                                        <input type="file" name="department_rule_file"
                                                            id="department_rule_file" accept=".pdf,.doc,.docx"
                                                            class="w-full border rounded px-3 py-2">
                                                    </div>

                                                    <div>
                                                        <label for="professor_rule_file"
                                                            class="block font-medium text-gray-700">University
                                                            Recommendation
                                                            (PDF,
                                                            DOC, DOCX)</label>
                                                        <input type="file" name="professor_rule_file"
                                                            id="professor_rule_file" accept=".pdf,.doc,.docx"
                                                            class="w-full border rounded px-3 py-2">
                                                    </div>

                                                    <div class="text-right">
                                                        <button type="submit"
                                                            class="inline-block bg-gradient-to-r from-green-100 to-blue-200 text-black text-sm font-semibold px-3 py-2 rounded transition">
                                                            Update Paper
                                                        </button>
                                                    </div>

                                                </form>
                                            </template>

                                        </div>
                                    </div>
                                </div>
                            @endif





                            {{--
                            @if (isset($notification->data['submission_id']))
                                <a href="{{ url('/submissions/' . $notification->data['submission_id']) }}"
                                    class="text-blue-600 underline">View submission</a>
                            @endif --}}
                        </div>
                        <form method="POST" action="{{ route('notifications.markRead', $notification->id) }}">
                            @csrf
                            <div class="bg-white rounded-lg shadow-lg overflow-y-auto max-h-[20vh] max-w-l  p-1">
                                <button type="submit" class="text-sm text-dark-600 hover:text-green-900">Mark
                                    read</button>
                            </div>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">You have no new notifications.</p>
        @endif
        <br><br>
        <h2 class="text-xl font-semibold mb-4">Read Notifications</h2>
        @php
            $readNotifications = auth()->user()->readNotifications()->get()->sortByDesc('created_at');

        @endphp

        @if ($readNotifications->count() > 0)
            <ul class="space-y-3">


                @foreach ($readNotifications as $notification)
                    <li class="border p-3 rounded bg-blue-50 flex justify-between items-center">
                        <div>
                            <p>{{ $notification->data['message'] }}</p>
                            {{--
                            @if (isset($notification->data['submission_id']))
                                <a href="{{ url('/submissions/' . $notification->data['submission_id']) }}"
                                    class="text-blue-600 underline">View submission</a>
                            @endif --}}
                        </div>

                    </li>
                @endforeach
            @else
                <p>No old notifications.</p>
        @endif
        </ul>
    @else
        <p class="text-gray-600">You have no new notifications.</p>
@endif
</div>
