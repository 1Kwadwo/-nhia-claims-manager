<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-chart-pie me-2"></i> Beneficiary Utilization Report
            </h2>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Beneficiary Utilization Summary</h6>
        </div>
        <div class="card-body">
            @if($beneficiaries->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Beneficiary</th>
                                <th>NHIS Number</th>
                                <th>Scheme Type</th>
                                <th>Total Claims</th>
                                <th>Total Amount</th>
                                <th>Average Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($beneficiaries as $beneficiary)
                                <tr>
                                    <td>{{ $beneficiary->full_name }}</td>
                                    <td>{{ $beneficiary->nhis_number }}</td>
                                    <td>
                                        <span class="badge bg-{{ $beneficiary->scheme_type === 'NHIS' ? 'success' : 'info' }}">
                                            {{ $beneficiary->scheme_type }}
                                        </span>
                                    </td>
                                    <td>{{ $beneficiary->claims_count }}</td>
                                    <td>GH₵ {{ number_format($beneficiary->total_amount, 2) }}</td>
                                    <td>GH₵ {{ number_format($beneficiary->average_amount, 2) }}</td>
                                    <td>
                                        <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="btn btn-sm btn-info">
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
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No beneficiaries found</h5>
                    <p class="text-muted">No beneficiary utilization data available.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
