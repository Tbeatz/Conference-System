<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($journal as $journals)
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition border border-gray-200">
            <h2 class="text-xl font-semibold text-green-700 mb-2">{{ $journals->description }}</h2>

            <div class="text-sm text-gray-700 space-y-1">

                <p><strong>Topic:</strong> {{ $journals->topic->name ?? 'N/A' }}</p>
                <p><strong>Author:</strong> {{ $journals->author->name ?? 'N/A' }}</p>
                <p><strong>Website:</strong> {{ $journals->journal_website ?? 'N/A' }}</p>
                <p><strong>Publication Date:</strong> {{ $journals->publication_date ?? 'N/A' }}</p>
                <p><strong>Contact Email:</strong> {{ $journals->contact_email ?? 'N/A' }}</p>
            </div>

            <div class="mt-4">
                @if ($journals->paper_path)
                    <a href="{{ asset('storage/' . $journals->paper_path) }}" target="_blank"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded transition">
                        View Paper
                    </a>

                    <a href="{{ asset('storage/' . $journals->paper_path) }}" download
                        class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded transition ml-2">
                        Download PDF
                    </a>
                @else
                    <p class="text-red-500 mt-2">No paper uploaded</p>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center col-span-full text-gray-500 py-12">
            <p class="text-lg font-medium">No journals available at the moment.</p>
        </div>
    @endforelse
</div>
