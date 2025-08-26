<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-file-medical me-2"></i> Claims
            </h2>
            <a href="{{ route('claims.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> New Claim
            </a>
        </div>
    </x-slot>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Medical Claims</h6>
        </div>
        <div class="card-body">
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
                                <th>Total Cost</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($claims as $claim)
                                <tr>
                                    <td>{{ $claim->claim_number }}</td>
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
                                    <td>
                                        <a href="{{ route('claims.show', $claim) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($claim->status === 'Draft')
                                            <a href="{{ route('claims.edit', $claim) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('claims.export-pdf', $claim) }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </td>
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
                    <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No claims found</h5>
                    <p class="text-muted">Get started by creating your first medical claim.</p>
                    <a href="{{ route('claims.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> New Claim
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
