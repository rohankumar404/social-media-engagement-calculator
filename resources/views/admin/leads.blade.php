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
                        <th>Email Captured</th>
                        <th>Intercept Source</th>
                        <th>Intent Logic</th>
                        <th>Capture Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leads as $lead)
                    <tr>
                        <td>{{ $lead->id }}</td>
                        <td><strong>{{ $lead->email }}</strong></td>
                        <td><span class="badge bg-info text-dark">{{ $lead->source }}</span></td>
                        <td>
                            @if($lead->intent_level === 'high')
                                <span class="badge bg-success">High</span>
                            @else
                                <span class="badge bg-secondary">Low</span>
                            @endif
                        </td>
                        <td>{{ $lead->created_at->format('M j, Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $leads->links() }}
        </div>
    </div>
</div>
@endsection
