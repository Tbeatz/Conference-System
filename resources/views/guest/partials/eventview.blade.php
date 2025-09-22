{{-- preparation --}}
<div class="conferenceresult-container p-6  text-yellow-800 rounded-xl shadow-lg max-w-4xl mx-auto">
    <h2 class="text-4xl font-bold mb-6 text-white text-center">Conferences</h2>

    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1">
        @forelse ($conferenceresult as $conferences)
            <div
                class="bg-white rounded-xl shadow-md p-6 border border-gray-200 hover:shadow-xl transition flex flex-col justify-between">
                <div>
                    {{-- <p class="text-xl font-semibold text-gray-700 leading-relaxed mb-4">
                            {{ $events->title ?? 'N/A' }}
                        </p> --}}

                    <h3 class="text-1xl font-semibold text-gray-700 mb-2">
                        <strong>Topic:</strong> {{ $conferences->topic->name ?? 'N/A' }}
                    </h3>
                    <p></p>

                    <h3 class="text-1xl font-semibold text-gray-700 mb-2">
                        <strong>Description</strong>
                    </h3>
                    <p class="text-1xl font-semibold text-gray-700 mb-2">{{ $conferences->description }}</p>


                    <div class="text-sm text-gray-700 space-y-1">


                        {{-- <p><strong>Author:</strong> {{ $conferences->author->name ?? 'N/A' }}</p>
                        <p><strong>Website:</strong> {{ $conferences->conference_website ?? 'N/A' }}</p> --}}
                        <p><strong>Publication Date:</strong> {{ $conferences->publication_date ?? 'N/A' }}</p>
                        <p><strong>Contact Email:</strong> {{ $conferences->contact_email ?? 'N/A' }}</p>
                    </div>
                </div>
                @if ($conferences->kpay_status == 'reviewed')
                    <div class="mt-4 flex flex-wrap gap-2">
                        @if ($conferences->paper_path)
                            <a href="{{ asset('storage/' . $conferences->paper_path) }}" target="_blank"
                                class="inline-block bg-gradient-to-r from-green-100 to-blue-200 text-black hover:bg-yellow-300  text-sm font-semibold px-3 py-2 rounded transition">
                                View Paper
                            </a>
                            <a href="{{ asset('storage/' . $conferences->paper_path) }}" download
                                class="inline-block bg-gradient-to-r from-green-100 to-blue-200 text-black hover:bg-yellow-300  text-sm font-semibold px-3 py-2 rounded transition">
                                Download PDF
                            </a>
                        @else
                            <p class="text-red-500 mt-2">No paper uploaded</p>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center text-gray-600 text-lg py-12 col-span-full">
                No conferences available at the moment.
            </div>
        @endforelse
    </div>
</div>
