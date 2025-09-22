{{-- preparation --}}
<!-- Full Width Container -->
<div class="w-full">

    <!-- First Banner -->
    <div class="relative text-center mb-10">
        <img src="{{ asset('assets/images/ucsp2025.jpg') }}" alt="ICAIIT 2025 Conference"
            class="w-full h-[300px] object-cover rounded-none shadow-lg">

        <!-- Overlay Text -->
        <div class="absolute inset-0 flex flex-col justify-center items-center text-white bg-black/40">
            <h1 class="text-3xl font-bold">
                2<sup>nd</sup> International Conference on Computer Science, Cybersecurity and Information Technology (ICCSCIT)
            </h1>
        </div>
    </div>

    <!-- Second Banner -->
    <div class="relative text-center mb-10 w-[80%] mx-auto rounded-md shadow-lg">
        <img src="{{ asset('assets/images/ucsp2025card.jpg') }}" alt="ICAIIT 2025 Conference"
            class="w-full h-[400px] object-cover rounded-md">

        <!-- Overlay Text -->
        <div class="absolute inset-0 flex flex-col justify-center items-center text-white bg-black/40 rounded-md">
            <h3 class="text-xl font-bold">2<sup>nd</sup>International Conference on Computer Science, Cybersecurity and Information Technology (ICCSCIT)</h3>
            <p class="mt-2 text-lg">
                Organized by <strong>University of Computer Studies, Pyay</strong><br>

            </p>
            <p class="mt-2 text-md">
                <strong>Date:</strong>15<sup>th</sup> October 2025 <br>
                <strong>Location:</strong> Pyay, Bago, Myanmar
            </p>
        </div>
    </div>



    <!-- Call for Papers Section -->
    <div class="w-full bg-white p-8 shadow-md">
        <h2 class="text-xl font-semibold text-blue-700 mb-4">Call for Papers</h2>
        <p class="text-xl font-semibold text-gray-700 leading-relaxed mb-4">
            {{ $events->title ?? 'N/A' }}
        </p>
        <p class="text-gray-700 leading-relaxed mb-4">
            {{-- @foreach ($event as $events) --}}
            {{ $events->description ?? 'N/A' }}

            {{-- @endforeach --}}
        </p>

        <p class="text-gray-700 leading-relaxed mb-4">
            Call for Reviewers –  We are seeking experts in AI and Machine Learning to review submissions for our premier conference.<br>
             Interested reviewers can <a href="{{ route('guest.home', ['section' => 'register']) }}" class="text-decoration-underline text-blue-500 border-bottom-2 border-info-subtle">Register here</a>.
        </p>
    </div>
</div>

{{-- List of Topics --}}
@php
    $chunks = $topics->chunk(ceil($topics->count() / 2));
@endphp

<div class="mt-10 bg-white rounded-xl shadow p-6 border border-gray-200">
    <h2 class="text-xl font-semibold text-blue-700 mb-4">Available Paper Topics</h2>

    <div class="grid grid-cols-2 gap-6 text-gray-800">
        @foreach ($chunks as $chunk)
            <ul class="list-disc list-inside space-y-1">
                @foreach ($chunk as $topic)
                    <li>{{ $topic->name }}</li>
                @endforeach
            </ul>
        @endforeach
    </div>
</div>


<section class="bg-white shadow rounded-lg p-6 my-6">
    <h2 class="text-xl font-semibold text-blue-700 mb-4">Organizing Committee</h2>

    <!-- General Chair section -->
    @if ($generalChair)
        <h3 class="text-xl font-semibold text-gray-700 mb-2">General Chair</h3>
        <p class="text-gray-800 mb-4">{{ $generalChair->title }} {{ $generalChair->name }},
            {{ $generalChair->affiliation }}</p>
    @endif

    <!-- Program Chair section -->
    @if ($programChair)
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Program Chair</h3>
        <p class="text-gray-800 mb-6">{{ $programChair->title }} {{ $programChair->name }},
            {{ $programChair->affiliation }}</p>
    @endif

    <!-- Other Organizing Committee Members as list -->
    <h3 class="text-xl font-semibold text-gray-700 mb-3">Organizing Committee Members</h3>
    <ul class="list-disc list-inside space-y-1 text-gray-800">
        @foreach ($members as $member)
            <li>
                {{ $member->title }} {{ $member->name }}, {{ $member->affiliation }}
                @if ($member->country && $member->country !== 'Myanmar')
                    , {{ $member->country }}
                @endif
            </li>
        @endforeach
    </ul>
</section>

{{-- Registration Fees --}}
<div class="mt-6 bg-white rounded-xl shadow p-6 border border-gray-200">
    <h2 class="text-2xl font-semibold text-blue-700 mb-4">Registration Fees</h2>

    @php
        // Get the first QR image if exists
        $qr = collect($infos['qr_image'] ?? [])->first()?->value;
    @endphp

    <div class="grid grid-cols-3 gap-4 text-lg text-gray-700 items-center">
        <div class="col-span-2">
            @foreach ($infos['fee'] ?? [] as $item)
                <div class="grid grid-cols-2 gap-2">
                    <div><strong>{{ $item->label }}:</strong></div>
                    <div>{{ $item->value }}</div>
                </div>
            @endforeach

            @foreach ($infos['email'] ?? [] as $item)
                <div class="grid grid-cols-2 gap-2">
                    <div><strong>{{ $item->label }}:</strong></div>
                    <div>
                        <a href="mailto:{{ $item->value }}" class="text-blue-600 underline">
                            {{ $item->value }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($qr)
            <div class="flex flex-col items-center">
                <p class="text-lg text-gray-700 mb-2 font-semibold">
                    Pay for scan QR and Paid
                </p>
                <img src="{{ asset('storage/' . $qr) }}" alt="QR Code" class="w-32 h-42">
            </div>
        @endif
    </div>
</div>
