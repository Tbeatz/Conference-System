@extends('admin.layout.layout')

@section('main-content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Author</h2>

        <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
            @csrf
            @method('PUT')

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Address -->
            {{-- <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                    value="{{ old('address', $user->address) }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}

            <!-- Position -->
            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
                    value="{{ old('position', $user->position) }}">
                @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Department -->
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" name="department" class="form-control @error('department') is-invalid @enderror"
                    value="{{ old('department', $user->department) }}">
                @error('department')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Organization -->
            <div class="mb-3">
                <label for="orginization" class="form-label">Organization</label>
                <input type="text" name="orginization" class="form-control @error('orginization') is-invalid @enderror"
                    value="{{ old('orginization', $user->orginization) }}">
                @error('orginization')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Field -->
            <div class="mb-3">
                <label for="field" class="form-label">Field</label>
                <input type="text" name="field" class="form-control @error('field') is-invalid @enderror"
                    value="{{ old('field', $user->field) }}">
                @error('field')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Author</button>
        </form>
    </div>
@endsection
