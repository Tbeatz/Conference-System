@extends('admin.layout.layout')

@section('main-content')
    <div class="pagetitle">
        <h1>Create Journal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guest.home') }}">Home</a></li>
                <li class="breadcrumb-item active">New Journal</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">New Journal Entry</h5>

                <form method="POST" action="{{ route('admin.journals.store') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="category_id" value="{{ $categories->first()->id ?? '' }}">

                    <div class="mb-3">
                        <label for="topic_id" class="form-label">Topic</label>
                        <select name="topic_id" class="form-control @error('topic_id') is-invalid @enderror" required>
                            <option value="">Select Topic</option>
                            @foreach ($topics as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                        @error('topic_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="paper_path" class="form-label">Upload Paper</label>
                        <input type="file" name="papers[]" multiple
                            class="form-control @error('paper_path') is-invalid @enderror" accept=".pdf,.doc,.docx">
                        {{-- <input type="file" name="paper_path"
                            class="form-control @error('paper_path') is-invalid @enderror"> --}}
                        @error('paper_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date"
                            class="form-control @error('start_date') is-invalid @enderror">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="publication_date" class="form-label">Publication Date</label>
                        <input type="date" name="publication_date"
                            class="form-control @error('publication_date') is-invalid @enderror">
                        @error('publication_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="journal_website" class="form-label">Journal Website</label>
                        <input type="url" name="journal_website"
                            class="form-control @error('journal_website') is-invalid @enderror">
                        @error('journal_website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" name="contact_email"
                            class="form-control @error('contact_email') is-invalid @enderror">
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="open">Open</option>
                            <option value="reviewing">Reviewing</option>
                            <option value="accepted">Accepted</option>
                            <option value="published">Published</option>
                            <option value="closed">Closed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Journal</button>
                </form>
            </div>
        </div>
    </section>
@endsection
