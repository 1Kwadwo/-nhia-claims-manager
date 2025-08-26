<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-file-medical me-2"></i> Claim Details
            </h2>
            <div>
                @if($claim->status === 'Draft')
                    <a href="{{ route('claims.edit', $claim) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i> Edit
                    </a>
                @endif
                <a href="{{ route('claims.index') }}" class="btn btn-info">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Claim Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Claim Number:</th>
                                    <td><strong>{{ $claim->claim_number ?? 'N/A' }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $claim->status ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date of Service:</th>
                                    <td>{{ $claim->date_of_service ? $claim->date_of_service->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Visit Type:</th>
                                    <td>{{ $claim->visit_type ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Provider:</th>
                                    <td>{{ $claim->provider->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Beneficiary:</th>
                                    <td>{{ $claim->beneficiary->full_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Total Cost:</th>
                                    <td><strong>GH₵ {{ number_format($claim->total_cost ?? 0, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $claim->created_at ? $claim->created_at->format('M d, Y H:i') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($claim->diagnoses)
                        <div class="mt-3">
                            <h6>Diagnoses:</h6>
                            <p>{{ is_array($claim->diagnoses) ? implode(', ', $claim->diagnoses) : $claim->diagnoses }}</p>
                        </div>
                    @endif

                    @if($claim->notes)
                        <div class="mt-3">
                            <h6>Notes:</h6>
                            <p>{{ $claim->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($claim->claimItems && $claim->claimItems->count() > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Claim Items</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Service Code</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($claim->claimItems as $item)
                                        <tr>
                                            <td>{{ $item->service_code ?? 'N/A' }}</td>
                                            <td>{{ $item->description ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $item->category ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>{{ $item->quantity ?? 0 }}</td>
                                            <td>GH₵ {{ number_format($item->unit_price ?? 0, 2) }}</td>
                                            <td><strong>GH₵ {{ number_format($item->amount ?? 0, 2) }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <th colspan="5" class="text-end">Total:</th>
                                        <th>GH₵ {{ number_format($claim->total_cost ?? 0, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Claim Items</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">No claim items found.</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Provider Details</h6>
                </div>
                <div class="card-body">
                    @if($claim->provider)
                        <h6>{{ $claim->provider->name ?? 'N/A' }}</h6>
                        <p class="text-muted mb-2">NHIS Code: {{ $claim->provider->nhis_code ?? 'N/A' }}</p>
                        @if($claim->provider->region)
                            <p class="text-muted mb-2">Region: {{ $claim->provider->region }}</p>
                        @endif
                        @if($claim->provider->phone)
                            <p class="text-muted mb-2">Phone: {{ $claim->provider->phone }}</p>
                        @endif
                        <a href="{{ route('providers.show', $claim->provider) }}" class="btn btn-sm btn-outline-primary">
                            View Provider
                        </a>
                    @else
                        <p class="text-muted">Provider information not available.</p>
                    @endif
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Beneficiary Details</h6>
                </div>
                <div class="card-body">
                    @if($claim->beneficiary)
                        <h6>{{ $claim->beneficiary->full_name ?? 'N/A' }}</h6>
                        <p class="text-muted mb-2">NHIS: {{ $claim->beneficiary->nhis_number ?? 'N/A' }}</p>
                        <p class="text-muted mb-2">Scheme: {{ $claim->beneficiary->scheme_type ?? 'N/A' }}</p>
                        @if($claim->beneficiary->sex)
                            <p class="text-muted mb-2">Sex: {{ $claim->beneficiary->sex }}</p>
                        @endif
                        <a href="{{ route('beneficiaries.show', $claim->beneficiary) }}" class="btn btn-sm btn-outline-info">
                            View Beneficiary
                        </a>
                    @else
                        <p class="text-muted">Beneficiary information not available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
