@extends('admin.layout.layout')

@section('main-content')

    <div class="pagetitle">
      <h1>Topics</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>

        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">New Topic</h5>

      <form method="POST" action="{{ route('admin.topics.update', $topic->id) }}">
    @csrf
    @method('PUT')

    <div class="row mb-3">
        <label for="name" class="col-sm-2 col-form-label">Topic Name</label>
        <div class="col-sm-10">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $topic->name) }}" required>

            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>


    </div>
  </div>
</section>


@endsection

