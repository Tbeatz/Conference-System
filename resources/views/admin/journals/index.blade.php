@extends('admin.layout.layout')

@section('main-content')
    <div class="pagetitle">
        <h1>All Journals</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guest.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Journals</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body pt-4">
                <a href="{{ route('admin.journals.create') }}" class="btn btn-primary mb-3">+ Create New Journal</a>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Topic</th>
                                <th>Description</th>
                                <th>Paper</th>
                                <th> Published:</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($journals as $journal)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $journal->category->name ?? '-' }}</td>
                                    <td>{{ $journal->topic->name ?? '-' }}</td>
                                    <td>{{ \Str::limit($journal->description, 50) }}</td>
                                    <td>
                                        @if ($journal->paper_path)
                                            <a href="{{ asset('storage/' . $journal->paper_path) }}" target="_blank">View
                                                Paper</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <small>

                                            {{ $journal->publication_date ?? '-' }}
                                        </small>
                                    </td>
                                    <td>{{ $journal->contact_email }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ ucfirst($journal->status) }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.journals.edit', $journal->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.journals.destroy', $journal->id) }}"
                                                method="POST" style="display:inline-block;"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
