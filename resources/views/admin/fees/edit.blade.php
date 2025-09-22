@extends('admin.layout.layout')

@section('main-content')
    <div class="pagetitle">
        <h1>Edit Registration Info</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guest.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.fees.index') }}">Registration Info</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit: {{ $info->label }}</h5>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.fees.update', $info->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div x-data="{ type: '{{ $info->type }}' }">
                        <!-- Type selection -->
                        <div class="mb-3"> <label for="type" class="form-label">Type</label> <select name="type"
                                id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="fee" {{ $info->type === 'fee' ? 'selected' : '' }}>Fee</option>
                                <option value="email" {{ $info->type === 'email' ? 'selected' : '' }}>Email</option>
                                <option value="qr_image" {{ $info->type === 'qr_image' ? 'selected' : '' }}>QR Code</option>
                            </select> @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Label -->
                        <div class="mb-3">
                            <label for="label" class="form-label">Label</label>
                            <input type="text" name="label" id="label" class="form-control"
                                value="{{ old('label', $info->label) }}" required>
                        </div>

                        <div class="mb-3" x-show="type !== 'qr_image'">
                            @if ($info->type != 'qr_image' && $info->value)
                                <label for="value" class="form-label">Value</label>

                                <input type="text" name="value" id="value" class="form-control"
                                    value="{{ old('value', $info->type !== 'qr_image' ? $info->value : '') }}">
                            @endif
                            {{-- <input type="text" name="value" id="value" class="form-control"
                                value="{{ old('value', $info->type !== 'qr_image' ? $info->value : '') }}"> --}}
                        </div>
                        @if ($info->type === 'qr_image' && $info->value)
                            <!-- File input for QR image -->
                            <div class="mb-3" x-show="type === 'qr_image'">
                                <label for="qr_image" class="form-label">QR Image</label>
                                <input type="file" name="qr_image" id="qr_image" class="form-control">

                                <!-- Show current QR image if exists -->
                                {{-- @if ($info->type === 'qr_image' && $info->value) --}}
                                {{-- <div class="mt-2">
                                    <p>Current QR Image:</p>
                                    <img src="{{ asset('storage/' . $info->value) }}" alt="QR"
                                        class="w-12 h-12 border">
                                </div> --}}

                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success">Update Info</button>
                    <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary">Cancel</a>
                </form>

            </div>
        </div>
    </section>
@endsection
