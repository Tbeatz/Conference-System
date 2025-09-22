<h6 class="custom-table">Search Results for "{{ $query }}"</h1>

    @if ($results->count())
        <a href="{{ route('admin.papers.conferences') }}">
            <div class="table-responsive">
                <table class="table table-bordered table-hover custom-table">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            {{-- <th>Event ID</th>
                        <th>User ID</th>
                        <th>Topic ID</th>
                        <th>Category ID</th> --}}
                            <th>Abstract</th>
                            <th>Keywords</th>
                            {{-- <th>Paper Path</th>
                        <th>Department Rule Path</th>
                        <th>Professor Rule Path</th> --}}
                            {{-- <th>Start Date</th>
                        <th>End Date</th> --}}
                            {{-- <th>Created At</th>
                        <th>Updated At</th>
                        <th>Edit Count</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($results as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                {{-- <td>{{ $item->event_id }}</td>
                            <td>{{ $item->user_id }}</td>
                            <td>{{ $item->topic_id }}</td>
                            <td>{{ $item->category_id }}</td> --}}
                                <td>{{ $item->abstract }}</td>
                                <td>{{ $item->keywords }}</td>
                                {{-- <td>
                                @if ($item->paper_path)
                                    <a href="{{ asset($item->paper_path) }}" target="_blank">View</a>
                                @endif
                            </td>
                            <td>
                                @if ($item->department_rule_path)
                                    <a href="{{ asset($item->department_rule_path) }}" target="_blank">View</a>
                                @endif
                            </td>
                            <td>
                                @if ($item->professor_rule_path)
                                    <a href="{{ asset($item->professor_rule_path) }}" target="_blank">View</a>
                                @endif
                            </td> --}}
                                {{-- <td>{{ $item->start_date }}</td>
                            <td>{{ $item->end_date }}</td> --}}
                                {{-- <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                            <td>{{ $item->edit_count }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </a>
    @else
        <p>No results found.</p>
    @endif
    <style>
        /* Full table background */
        .custom-table {
            background-color: #f9f9f9;
            /* Light gray for table background */
            border-collapse: separate;
            border-spacing: 0;
        }

        /* Header style */
        .custom-table thead th {
            background-color: #343a40;
            /* Dark header */
            color: #fff;
            text-align: left;
            padding: 10px;
        }

        /* Body rows alternate background */
        .custom-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
            /* White */
        }

        .custom-table tbody tr:nth-child(even) {
            background-color: #e9ecef;
            /* Light gray */
        }

        /* Hover effect */
        .custom-table tbody tr:hover {
            background-color: #d1ecf1;
            /* Light blue */
            cursor: pointer;
        }

        /* Table cells padding */
        .custom-table td {
            padding: 10px;
        }
    </style>
