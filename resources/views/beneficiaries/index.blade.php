<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-users me-2"></i> Beneficiaries
            </h2>
            <a href="{{ route('beneficiaries.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add Beneficiary
            </a>
        </div>
    </x-slot>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">NHIS Beneficiaries</h6>
        </div>
        <div class="card-body">
            @if($beneficiaries->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>NHIS Number</th>
                                <th>Full Name</th>
                                <th>Date of Birth</th>
                                <th>Sex</th>
                                <th>Scheme Type</th>
                                <th>Expiry Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($beneficiaries as $beneficiary)
                                <tr>
                                    <td>{{ $beneficiary->nhis_number }}</td>
                                    <td>{{ $beneficiary->full_name }}</td>
                                    <td>{{ $beneficiary->date_of_birth ? $beneficiary->date_of_birth->format('M d, Y') : 'N/A' }}</td>
                                    <td>{{ $beneficiary->sex }}</td>
                                    <td>
                                        <span class="badge bg-{{ $beneficiary->scheme_type === 'NHIS' ? 'success' : 'info' }}">
                                            {{ $beneficiary->scheme_type }}
                                        </span>
                                    </td>
                                    <td>{{ $beneficiary->expiry_date ? $beneficiary->expiry_date->format('M d, Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('beneficiaries.destroy', $beneficiary) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center">
                    {{ $beneficiaries->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No beneficiaries found</h5>
                    <p class="text-muted">Get started by adding your first NHIS beneficiary.</p>
                    <a href="{{ route('beneficiaries.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Add Beneficiary
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
