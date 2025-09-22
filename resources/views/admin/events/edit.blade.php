@extends('admin.layout.layout')

@section('main-content')
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Event</h5>

      <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="title" class="form-label">Event Title</label>
          <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                 value="{{ old('title', $event->title) }}" required>
          @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="category_id" class="form-label">Category</label>
          <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
            <option value="">-- Select Category --</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}"
                {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
          @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- <div class="mb-3">
          <label>Topics</label>
          <div class="row">
            @foreach($topics as $topic)
              <div class="col-md-4">
                <div class="form-check">
                  <input type="checkbox" name="topics[]" id="topic_{{ $topic->id }}"
                         value="{{ $topic->id }}"
                         class="form-check-input"
                         {{ in_array($topic->id, old('topics', $event->topics->pluck('id')->toArray())) ? 'checked' : '' }}>
                  <label class="form-check-label" for="topic_{{ $topic->id }}">{{ $topic->name }}</label>
                </div>
              </div>
            @endforeach
          </div>
          @error('topics')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div> --}}

        <div class="mb-3">
          <label for="start_date" class="form-label">Start Date</label>
          <input type="date" name="start_date" class="form-control"
                 value="{{ old('start_date', $event->start_date) }}">
        </div>

        <div class="mb-3">
          <label for="end_date" class="form-label">End Date</label>
          <input type="date" name="end_date" class="form-control"
                 value="{{ old('end_date', $event->end_date) }}">
        </div>

        <div class="mb-3">
          <label for="location" class="form-label">Location</label>
          <input type="text" name="location" class="form-control"
                 value="{{ old('location', $event->location) }}">
        </div>

        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select name="status" class="form-control">
            <option value="upcoming" {{ old('status', $event->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
            <option value="open" {{ old('status', $event->status) == 'open' ? 'selected' : '' }}>Open</option>
            <option value="closed" {{ old('status', $event->status) == 'closed' ? 'selected' : '' }}>Closed</option>
            <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Event</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</section>
@endsection
