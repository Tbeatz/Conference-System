@extends('admin.layout.layout')

@section('main-content')
    <div class="pagetitle">
        <h1>Registration Fees & Contact Info</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guest.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Registration Info</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">List of Fees & Emails</h5>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <a href="{{ route('admin.fees.create') }}" class="btn btn-primary mb-3">Add New</a>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Label</th>
                            <th>Value</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($infos as $index => $info)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge bg-{{ $info->type === 'fee' ? 'success' : 'info' }}">
                                        {{ ucfirst($info->type) }}
                                    </span>
                                </td>
                                <td>{{ $info->label }}</td>
                                <td>
                                    @if ($info->type === 'email')
                                        <a href="mailto:{{ $info->value }}" class="text-primary">{{ $info->value }}</a>
                                    @else
                                        {{ $info->value }}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.fees.edit', $info->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        {{-- <form action="{{ route('admin.fees.destroy', $info->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form> --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No registration info found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </section>
@endsection
