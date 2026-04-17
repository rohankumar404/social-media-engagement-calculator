@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Admin Overview</h2>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="text-muted">Total Users</h5>
                    <h2 class="display-5 fw-bold">{{ $metrics['total_users'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="text-muted">Total Run Calculations</h5>
                    <h2 class="display-5 fw-bold text-success">{{ $metrics['total_reports'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="text-muted">Total Leads Captured</h5>
                    <h2 class="display-5 fw-bold text-primary">{{ $metrics['total_leads'] }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-white pt-3 pb-3">
            <h5 class="mb-0">Recent Platform Engagement Scans</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>User ID</th>
                        <th>Platform</th>
                        <th>Engagement Yield</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($metrics['recent_reports'] as $report)
                    <tr>
                        <td>{{ $report->created_at->format('M j Y') }}</td>
                        <td>{{ $report->user_id ?? 'Guest' }}</td>
                        <td>{{ $report->platform }}</td>
                        <td><strong>{{ $report->engagement_rate }}%</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
