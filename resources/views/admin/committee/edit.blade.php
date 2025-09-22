@extends('admin.layout.layout')

@section('main-content')
    <div class="pagetitle">
        <h1>Edit Committee Member</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guest.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.committee.index') }}">Committee</a></li>
                <li class="breadcrumb-item active">Edit Member</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Update Committee Member</h5>

                <form method="POST" action="{{ route('admin.committee.update', $member->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="">Select Role</option>
                                <option value="general_chair" {{ $member->role === 'general_chair' ? 'selected' : '' }}>
                                    General Chair</option>
                                <option value="program_chair" {{ $member->role === 'program_chair' ? 'selected' : '' }}>
                                    Program Chair</option>
                                <option value="member" {{ $member->role === 'member' ? 'selected' : '' }}>Member</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="title" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $member->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $member->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="affiliation" class="col-sm-2 col-form-label">Affiliation</label>
                        <div class="col-sm-10">
                            <input type="text" name="affiliation"
                                class="form-control @error('affiliation') is-invalid @enderror"
                                value="{{ old('affiliation', $member->affiliation) }}" required>
                            @error('affiliation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="country" class="col-sm-2 col-form-label">Country</label>
                        <div class="col-sm-10">
                            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                                value="{{ old('country', $member->country) }}">
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Update Member</button>
                    <a href="{{ route('admin.committee.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
@endsection
