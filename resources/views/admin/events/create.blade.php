@extends('admin.layout.layout')

@section('main-content')
    <div class="container">
        <h1>Create Event</h1>

        <form method="POST" action="{{ route('admin.events.store') }}">
            @csrf

            {{-- ✅ Validation Errors Display --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                    value="{{ old('location') }}" required>
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                    value="{{ old('start_date') }}" required>
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                    value="{{ old('end_date') }}" required>
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="publication_partner" class="form-label">Publication_partner</label>
                <input type="text" name="publication_partner"
                    class="form-control @error('publication_partner') is-invalid @enderror"
                    value="{{ old('publication_partner') }}" required>
                @error('publication_partner')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="submission_deadline" class="form-label">Submission Deadline</label>
                <input type="date" name="submission_deadline"
                    class="form-control @error('submission_deadline') is-invalid @enderror"
                    value="{{ old('submission_deadline') }}" required>
                @error('submission_deadline')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="acceptance_date" class="form-label">Acceptance Date</label>
                <input type="date" name="acceptance_date"
                    class="form-control @error('acceptance_date') is-invalid @enderror"
                    value="{{ old('acceptance_date') }}" required>
                @error('acceptance_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="camera_ready_deadline" class="form-label">Camera Ready Deadline</label>
                <input type="date" name="camera_ready_deadline"
                    class="form-control @error('camera_ready_deadline') is-invalid @enderror"
                    value="{{ old('camera_ready_deadline') }}" required>
                @error('camera_ready_deadline')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="event_website" class="form-label">Event Website</label>
                <input type="text" name="event_website" class="form-control @error('event_website') is-invalid @enderror"
                    value="{{ old('event_website') }}" required>
                @error('event_website')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="organizer" class="form-label">Organizer</label>
                <input type="text" name="organizer" class="form-control @error('organizer') is-invalid @enderror"
                    value="{{ old('organizer') }}" required>
                @error('organizer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="contact_email" class="form-label">Contact Email</label>
                <input type="email" name="contact_email"
                    class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email') }}"
                    required>
                @error('contact_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="categories">Select Category</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror"
                    id="categories">
                    <option value="">-- Choose a Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- <div class="mb-3">
                <label>Select Topics</label>
                <div class="row">
                    @foreach ($topics as $topic)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input @error('topics') is-invalid @enderror" type="checkbox"
                                    name="topics[]" value="{{ $topic->id }}" id="topic_{{ $topic->id }}"
                                    {{ in_array($topic->id, old('topics', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="topic_{{ $topic->id }}">
                                    {{ $topic->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach

                    @error('topics')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div> --}}


            {{-- <div class="row mb-3">
                  <div class="col-sm-10 offset-sm-2">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="gridCheck1">
                      <label class="form-check-label" for="gridCheck1">
                        Select Topics
                      </label>
                    </div>
                  </div>
                </div> --}}


            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="">-- Choose Status --</option>
                    <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Create Event</button>
        </form>
    </div>
@endsection
