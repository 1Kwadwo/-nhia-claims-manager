<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </h2>
    </x-slot>

    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Claims
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalClaims) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Providers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalProviders) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hospital-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Beneficiaries
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalBeneficiaries) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Tariffs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalTariffs) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Claims by Status -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Claims by Status</h6>
                </div>
                <div class="card-body">
                    @if(count($claimsByStatus) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Count</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($claimsByStatus as $status => $count)
                                        <tr>
                                            <td>
                                                <span class="badge bg-{{ $status === 'Approved' ? 'success' : ($status === 'Rejected' ? 'danger' : ($status === 'Paid' ? 'info' : 'secondary')) }}">
                                                    {{ $status }}
                                                </span>
                                            </td>
                                            <td>{{ $count }}</td>
                                            <td>GH₵ {{ number_format($amountsByStatus[$status] ?? 0, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No claims data available.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Providers -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Providers by Claims</h6>
                </div>
                <div class="card-body">
                    @if(count($claimsPerProvider) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Provider</th>
                                        <th>Claims Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($claimsPerProvider as $stat)
                                        <tr>
                                            <td>{{ $stat->provider->name ?? 'Unknown' }}</td>
                                            <td>{{ $stat->count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No provider data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Monthly Claims Chart -->
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Claims Overview</h6>
                </div>
                <div class="card-body">
                    @if(count($monthlyClaims) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Claims Count</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthlyClaims as $monthly)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $monthly->month)->format('M Y') }}</td>
                                            <td>{{ $monthly->count }}</td>
                                            <td>GH₵ {{ number_format($monthly->total_amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No monthly claims data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('claims.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-plus me-2"></i> New Claim
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('providers.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-hospital me-2"></i> Add Provider
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('beneficiaries.create') }}" class="btn btn-info btn-block">
                                <i class="fas fa-user-plus me-2"></i> Add Beneficiary
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('reports.index') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-chart-bar me-2"></i> View Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
