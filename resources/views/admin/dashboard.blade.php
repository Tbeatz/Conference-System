@extends('admin.layout.layout')
@section('main-content')
    <div class="container my-4">
        <div class="row g-4">
            <!-- Author Card -->
            <div class="col-md-3">
                <a href="{{ route('admin.user.author') }}">
                    <div class="card text-dark" style="background-color: #cfe2ff;"> <!-- light blue -->
                        <div class="card-body">
                            <h5 class="card-title">Authors</h5>
                            <h2 class="card-text">{{ $authorCount }}</h2>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Reviewer Card -->
            <div class="col-md-3">
                <a href="{{ route('admin.user.reviewer') }}">
                    <div class="card text-dark" style="background-color: #d1e7dd;"> <!-- light green -->
                        <div class="card-body">
                            <h5 class="card-title">Reviewers</h5>
                            <h2 class="card-text">{{ $reviewerCount }}</h2>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Paper Card -->
            <div class="col-md-3">
                <a href="{{ route('admin.papers.conferences') }}">
                    <div class="card text-dark" style="background-color: #fff3cd;"> <!-- light yellow -->
                        <div class="card-body">
                            <h5 class="card-title">Total Papers</h5>
                            <h2 class="card-text">{{ $paperCount }}</h2>
                        </div>
                    </div>
                </a>
            </div>

            <!-- User Card -->
            <div class="col-md-3">
                <div class="card text-dark" style="background-color: #f8d7da;"> <!-- light red/pink -->
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <h2 class="card-text">{{ $totalUsers }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart under User Count -->
        <div class="row mt-4">
            <div class="col-md-5">
                <canvas id="rolePieChart"></canvas>
            </div>
            <!-- Bar Chart -->
            <div class="col-md-7">
                <a href="{{ route('admin.papers.conferences') }}">
                    <canvas id="paperCountChart"></canvas>
                </a>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // --- Pie Chart: Role Distribution ---
        const roleCtx = document.getElementById('rolePieChart').getContext('2d');

        const roleLabels = [
            @foreach ($roleDistribution as $role)
                '{{ $role->name }}'
                {{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        const roleData = [
            @foreach ($roleDistribution as $role)
                {{ $role->count }}{{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        new Chart(roleCtx, {
            type: 'pie',
            data: {
                labels: roleLabels,
                datasets: [{
                    data: roleData,
                    backgroundColor: [
                        '#9ec5fe', // light blue
                        '#a3e4c4', // light green
                        '#ffe5a3', // light yellow
                        '#f5a3a3', // light red/pink
                        '#cda3f5', // light purple
                        '#ffd7a3' // light orange
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: false
                    }
                }
            }
        });

        // --- Bar Chart: Paper Counts ---
        const paperCtx = document.getElementById('paperCountChart').getContext('2d');

        const paperLabels = [
            @foreach ($paperCounts as $item)
                '{{ $item->date }}'
                {{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        const paperData = [
            @foreach ($paperCounts as $item)
                {{ $item->count }}{{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        new Chart(paperCtx, {
            type: 'bar',
            data: {
                labels: paperLabels,
                datasets: [{
                    label: 'Paper Count',
                    data: paperData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Papers Submitted by Date'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Paper Count'
                        }
                    }
                }
            }
        });
    </script>
@endsection
