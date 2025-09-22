@extends('admin.layout.layout')

@section('content')
<div class="pagetitle">
  <h1>Edit Topic</h1>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Update Topic</h5>

      <form action="{{ route('topics.update', $topic->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row mb-3">
          <label for="name" class="col-sm-2 col-form-label">Topic Name</label>
          <div class="col-sm-10">
            <input type="text" name="name" class="form-control" value="{{ $topic->name }}" required>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>

    </div>
  </div>
</section>
@endsection
