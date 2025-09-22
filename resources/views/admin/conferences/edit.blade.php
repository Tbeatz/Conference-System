@extends('admin.layout.layout')

@section('main-content')
    <div class="pagetitle">
        <h1>Edit Conference</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guest.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit Conference</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Update Conference Entry</h5>

                <form method="POST" action="{{ route('admin.conferences.update', $conference->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $conference->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="topic_id" class="form-label">Topic</label>
                        <select name="topic_id" class="form-control @error('topic_id') is-invalid @enderror" required>
                            <option value="">Select Topic</option>
                            @foreach ($topics as $topic)
                                <option value="{{ $topic->id }}"
                                    {{ $conference->topic_id == $topic->id ? 'selected' : '' }}>
                                    {{ $topic->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('topic_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $conference->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="paper_path" class="form-label">Upload New Papers (optional)</label>
                        <input type="file" name="papers[]" multiple
                            class="form-control @error('paper_path') is-invalid @enderror" accept=".pdf,.doc,.docx">
                        @if ($conference->paper_path)
                            <p class="mt-2">Current file: <a href="{{ asset('storage/' . $conference->paper_path) }}"
                                    target="_blank">View Merged File</a></p>
                        @endif
                        @error('paper_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date"
                            class="form-control @error('start_date') is-invalid @enderror"
                            value="{{ old('start_date', $conference->start_date) }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                            value="{{ old('end_date', $conference->end_date) }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="publication_date" class="form-label">Publication Date</label>
                        <input type="date" name="publication_date"
                            class="form-control @error('publication_date') is-invalid @enderror"
                            value="{{ old('publication_date', $conference->publication_date) }}">
                        @error('publication_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="conference_website" class="form-label">Conference Website</label>
                        <input type="url" name="conference_website"
                            class="form-control @error('conference_website') is-invalid @enderror"
                            value="{{ old('conference_website', $conference->conference_website) }}">
                        @error('conference_website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" name="contact_email"
                            class="form-control @error('contact_email') is-invalid @enderror"
                            value="{{ old('contact_email', $conference->contact_email) }}">
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            @foreach (['open', 'reviewing', 'accepted', 'published', 'closed'] as $status)
                                <option value="{{ $status }}"
                                    {{ $conference->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Update Conference</button>
                    <a href="{{ route('admin.conferences.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
@endsection
