@extends('admin.layout.layout')

@section('main-content')
<div class="card">
    <div class="card-body">
        <h3 class="card-title">Event Details</h3>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Title</th>
                    <td>{{ $event->title }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $event->description }}</td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td>{{ $event->location }}</td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td>{{ $event->start_date }}</td>
                </tr>
                <tr>
                    <th>End Date</th>
                    <td>{{ $event->end_date }}</td>
                </tr>
                <tr>
                    <th>Submission Deadline</th>
                    <td>{{ $event->submission_deadline }}</td>
                </tr>
                <tr>
                    <th>Acceptance Date</th>
                    <td>{{ $event->acceptance_date }}</td>
                </tr>
                <tr>
                    <th>Camera Ready Deadline</th>
                    <td>{{ $event->camera_ready_deadline }}</td>
                </tr>
                <tr>
                    <th>Event Website</th>
                    <td><a href="{{ $event->event_website }}" target="_blank">{{ $event->event_website }}</a></td>
                </tr>
                <tr>
                    <th>Organizer</th>
                    <td>{{ $event->organizer }}</td>
                </tr>
                <tr>
                    <th>Contact Email</th>
                    <td>{{ $event->contact_email }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($event->status) }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $event->category->name }}</td>
                </tr>
                <tr>
                    <th>Topics</th>
                    <td>
                        <ul class="mb-0">
                            @foreach($event->topics as $topic)
                                <li>{{ $topic->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>
@endsection
