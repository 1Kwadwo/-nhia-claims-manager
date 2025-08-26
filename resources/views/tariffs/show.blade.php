<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-list-alt me-2"></i> Tariff Details
            </h2>
            <div>
                <a href="{{ route('tariffs.edit', $tariff) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i> Edit
                </a>
                <a href="{{ route('tariffs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tariff Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Service Code:</th>
                            <td><strong>{{ $tariff->service_code }}</strong></td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $tariff->description }}</td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td>
                                <span class="badge bg-{{ 
                                    $tariff->category === 'Consultation' ? 'primary' : 
                                    ($tariff->category === 'Lab' ? 'info' : 
                                    ($tariff->category === 'Drug' ? 'success' : 
                                    ($tariff->category === 'Procedure' ? 'warning' : 'secondary'))) 
                                }}">
                                    {{ $tariff->category }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Unit Price:</th>
                            <td><strong>GH₵ {{ number_format($tariff->unit_price, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Effective Date:</th>
                            <td>{{ $tariff->effective_date ? $tariff->effective_date->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td>{{ $tariff->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Usage Summary</h6>
                </div>
                <div class="card-body">
                    @if($tariff->claimItems->count() > 0)
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-primary">{{ $tariff->claimItems->count() }}</h4>
                                <p class="text-muted">Times Used</p>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success">GH₵ {{ number_format($tariff->claimItems->sum('amount'), 2) }}</h4>
                                <p class="text-muted">Total Amount</p>
                            </div>
                        </div>
                        
                        <h6 class="mt-3">Recent Usage</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Claim #</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tariff->claimItems->take(5) as $item)
                                        <tr>
                                            <td>
                                                <a href="{{ route('claims.show', $item->claim) }}">{{ $item->claim->claim_number }}</a>
                                            </td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>GH₵ {{ number_format($item->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No usage found</h5>
                            <p class="text-muted">This tariff has not been used in any claims yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
