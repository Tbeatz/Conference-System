@extends('admin.layout.layout')

@section('main-content')
{{-- <div class="container">
    <a href="{{ route('admin.journals.create') }}" class="btn btn-success mb-3">Create Journal</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Volume</th>
                <th>Year</th>
                <th>Publishing Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($journals as $journal)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $journal->title }}</td>
                <td>{{ $journal->volume_no }}</td>
                <td>{{ $journal->year }}</td>
                <td>{{ $journal->publishing_date }}</td>
                <td>

                    <a href="{{ route('admin.journals.edit', $journal->id) }}" class="btn btn-info">View/Edit</a>
                    <form action="{{ route('admin.journals.destroy', $journal->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}

{{-- <h4>Category: {{ $event->category->name }}</h4>

<h5>Topics:</h5>
<ul>
    @foreach($event->category->topics as $topic)
        <li>{{ $topic->name }}</li>
    @endforeach
</ul> --}}

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Events List</h5>

      <table class="table datatable">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Category</th>
            <th></th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($events as $event)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $event->title }}</td>
              <td>{{ $event->category->name ?? 'N/A' }}</td>
              <td>
                <ul class="mb-0">
                  @foreach($event->topics as $topic)
                    <li>{{ $topic->name }}</li>
                  @endforeach
                </ul>
              </td>
              <td>{{ ucfirst($event->status) }}</td>
              <td>
                <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-info btn-sm">View Details</a>
                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline;">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</section>
@endsection
