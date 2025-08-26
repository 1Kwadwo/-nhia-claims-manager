<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-chart-line me-2"></i> Claims Summary Report
            </h2>
            <div>
                <a href="{{ route('reports.claims-summary.export-pdf') }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf me-2"></i> Export PDF
                </a>
                <a href="{{ route('reports.claims-summary.export-csv') }}" class="btn btn-success">
                    <i class="fas fa-file-csv me-2"></i> Export CSV
                </a>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Claims Summary</h6>
        </div>
        <div class="card-body">
            <div class="row text-center mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h4>{{ $totalClaims }}</h4>
                            <p class="mb-0">Total Claims</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h4>GH₵ {{ number_format($totalAmount, 2) }}</h4>
                            <p class="mb-0">Total Amount</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h4>{{ $approvedClaims }}</h4>
                            <p class="mb-0">Approved Claims</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h4>{{ $pendingClaims }}</h4>
                            <p class="mb-0">Pending Claims</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($claims->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Claim Number</th>
                                <th>Provider</th>
                                <th>Beneficiary</th>
                                <th>Date of Service</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($claims as $claim)
                                <tr>
                                    <td>
                                        <a href="{{ route('claims.show', $claim) }}">{{ $claim->claim_number }}</a>
                                    </td>
                                    <td>{{ $claim->provider->name ?? 'N/A' }}</td>
                                    <td>{{ $claim->beneficiary->full_name ?? 'N/A' }}</td>
                                    <td>{{ $claim->date_of_service->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $claim->status === 'Approved' ? 'success' : 
                                            ($claim->status === 'Rejected' ? 'danger' : 
                                            ($claim->status === 'Paid' ? 'info' : 'secondary')) 
                                        }}">
                                            {{ $claim->status }}
                                        </span>
                                    </td>
                                    <td>GH₵ {{ number_format($claim->total_cost, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center">
                    {{ $claims->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No claims found</h5>
                    <p class="text-muted">No claims match the current filters.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
