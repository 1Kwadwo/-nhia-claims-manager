<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-hospital-user me-2"></i> Provider Details
            </h2>
            <div>
                <a href="{{ route('providers.edit', $provider) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i> Edit
                </a>
                <a href="{{ route('providers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Provider Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Name:</th>
                            <td>{{ $provider->name }}</td>
                        </tr>
                        <tr>
                            <th>NHIS Code:</th>
                            <td>{{ $provider->nhis_code }}</td>
                        </tr>
                        <tr>
                            <th>Region:</th>
                            <td>{{ $provider->region ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $provider->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $provider->address ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td>{{ $provider->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Claims Summary</h6>
                </div>
                <div class="card-body">
                    @if($provider->claims->count() > 0)
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-primary">{{ $provider->claims->count() }}</h4>
                                <p class="text-muted">Total Claims</p>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success">GH₵ {{ number_format($provider->claims->sum('total_cost'), 2) }}</h4>
                                <p class="text-muted">Total Amount</p>
                            </div>
                        </div>
                        
                        <h6 class="mt-3">Recent Claims</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Claim #</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($provider->claims->take(5) as $claim)
                                        <tr>
                                            <td>
                                                <a href="{{ route('claims.show', $claim) }}">{{ $claim->claim_number }}</a>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $claim->status === 'Approved' ? 'success' : 
                                                    ($claim->status === 'Rejected' ? 'danger' : 'secondary') 
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
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No claims found</h5>
                            <p class="text-muted">This provider has no claims yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
