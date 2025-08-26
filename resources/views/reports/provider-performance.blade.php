<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-chart-bar me-2"></i> Provider Performance Report
            </h2>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Provider Performance Summary</h6>
        </div>
        <div class="card-body">
            @if($providers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Provider</th>
                                <th>NHIS Code</th>
                                <th>Region</th>
                                <th>Total Claims</th>
                                <th>Total Amount</th>
                                <th>Average Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($providers as $provider)
                                <tr>
                                    <td>{{ $provider->name }}</td>
                                    <td>{{ $provider->nhis_code }}</td>
                                    <td>{{ $provider->region ?? 'N/A' }}</td>
                                    <td>{{ $provider->claims_count }}</td>
                                    <td>GH₵ {{ number_format($provider->total_amount, 2) }}</td>
                                    <td>GH₵ {{ number_format($provider->average_amount, 2) }}</td>
                                    <td>
                                        <a href="{{ route('providers.show', $provider) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-hospital fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No providers found</h5>
                    <p class="text-muted">No provider performance data available.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
