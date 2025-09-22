<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($conference as $conferences)
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition border border-gray-200">
            <h2 class="text-xl font-semibold text-green-700 mb-2">{{ $conferences->description }}</h2>

            <div class="text-sm text-gray-700 space-y-1">
                
                <p><strong>Topic:</strong> {{ $conferences->topic->name ?? 'N/A' }}</p>
                <p><strong>Author:</strong> {{ $conferences->author->name ?? 'N/A' }}</p>
                <p><strong>Website:</strong> {{ $conferences->conference_website ?? 'N/A' }}</p>
                <p><strong>Publication Date:</strong> {{ $conferences->publication_date ?? 'N/A' }}</p>
                <p><strong>Contact Email:</strong> {{ $conferences->contact_email ?? 'N/A' }}</p>
            </div>

            <div class="mt-4">
                @if ($conferences->paper_path)
                    <a href="{{ asset('storage/' . $conferences->paper_path) }}" target="_blank"
                        class="inline-block bg-gradient-to-r from-green-100 to-blue-200 text-black text-sm font-semibold px-3 py-2 rounded transition">
                        View Paper
                    </a>

                    <a href="{{ asset('storage/' . $conferences->paper_path) }}" download
                        class="inline-block bg-gradient-to-r from-green-100 to-blue-200 text-black text-sm font-semibold px-3 py-2 rounded transition">
                        Download PDF
                    </a>
                @else
                    <p class="text-red-500 mt-2">No paper uploaded</p>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center text-gray-600 text-lg py-12">
            No conferences available at the moment.
        </div>
    @endforelse
</div>
