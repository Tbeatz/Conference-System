@extends('admin.layout.layout')

@section('main-content')
    <div class="pagetitle">
        <h1>Organizing Committee Members</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guest.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Committee Members</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Committee Members List</h5>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <a href="{{ route('admin.committee.create') }}" class="btn btn-primary mb-3">Add New Member</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Title</th>
                            <th>Name</th>
                            <th>Affiliation</th>
                            <th>Country</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $index => $member)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @switch($member->role)
                                        @case('general_chair')
                                            General Chair
                                        @break

                                        @case('program_chair')
                                            Program Chair
                                        @break

                                        @default
                                            Member
                                    @endswitch
                                </td>
                                <td>{{ $member->title }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->affiliation }}</td>
                                <td>{{ $member->country ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.committee.edit', $member->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.committee.destroy', $member->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this member?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No committee members found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </section>
    @endsection
