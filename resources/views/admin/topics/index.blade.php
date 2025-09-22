@extends('admin.layout.layout')

@section('main-content')



    <div class="pagetitle">
      <h1>Form Layouts</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item active">Layouts</li>
        </ol>
      </nav>
    </div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Topics List</h5>
      <a href="{{ route('admin.topics.create') }}" class="btn btn-primary mb-3">Add New Topic</a>

      <table class="table datatable">
        <thead>
          <tr>
            <th>#</th>
            <th>Topic Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($topics as $topic)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $topic->name }}</td>
              <td>
                <a href="{{ route('admin.topics.edit', $topic->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.topics.destroy', $topic->id) }}" method="POST" style="display:inline;">
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
