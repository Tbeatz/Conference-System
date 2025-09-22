@extends('admin.layout.layout')

@section('main-content')
    <div class="pagetitle">
        <h1>Contact Messages</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guest.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Messages</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body pt-4">
                <h5 class="card-title">All Messages</h5>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                {{-- <th>Status</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $message->name ?? '-' }}</td>
                                    <td>{{ $message->email ?? '-' }}</td>
                                    <td>{{ $message->subject ?? '-' }}</td>
                                    <td>
                                        <div x-data="{ expanded: false }" x-cloak>
                                            <span x-show="!expanded">
                                                {{ \Str::limit($message->message, 30, '...') }}
                                            </span>
                                            <span x-show="expanded">
                                                {{ $message->message ?? '-' }}
                                            </span>

                                            @if (strlen($message->message) > 30)
                                                <button class="btn btn-sm btn-primary ms-2" @click="expanded = !expanded"
                                                    x-text="expanded ? 'See Less' : 'See More'">
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <span
                                            class="badge {{ $message->status == 'responded' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ ucfirst($message->status) }}
                                        </span>
                                    </td> --}}
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- <a href="{{ route('admin.contact.show', $message->id) }}"
                                                class="btn btn-sm btn-info">View</a>

                                            <form action="{{ route('admin.contact.responded', $message->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-sm btn-success"
                                                    onclick="return confirm('Mark this message as responded?');">
                                                    Mark Responded
                                                </button>
                                            </form> --}}

                                            <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure to delete this message?');">
                                                    Delete
                                                </button>
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

<script src="//unpkg.com/alpinejs" defer></script>
