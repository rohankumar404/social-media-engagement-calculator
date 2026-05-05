@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Leads Captured</h2>
        <a href="{{ route('admin.leads.export') }}" class="btn btn-success"><i class="bi bi-file-earmark-arrow-down"></i> Export All to CSV</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Source</th>
                        <th>Intent</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leads as $lead)
                    <tr>
                        <td>{{ $lead->id }}</td>
                        <td>{{ $lead->name ?? 'N/A' }}</td>
                        <td><strong>{{ $lead->email }}</strong></td>
                        <td>{{ $lead->phone ?? 'N/A' }}</td>
                        <td><span class="badge bg-info text-dark">{{ $lead->source }}</span></td>
                        <td>
                            @if(strtolower($lead->intent_level) === 'high')
                                <span class="badge bg-success">High</span>
                            @else
                                <span class="badge bg-secondary">Low</span>
                            @endif
                        </td>
                        <td>{{ $lead->created_at->format('M j, H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $leads->links() }}
        </div>
    </div>
</div>
@endsection
