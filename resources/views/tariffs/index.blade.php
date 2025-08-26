<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-list-alt me-2"></i> Tariffs
            </h2>
            <a href="{{ route('tariffs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add Tariff
            </a>
        </div>
    </x-slot>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Service Tariffs</h6>
        </div>
        <div class="card-body">
            @if($tariffs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Service Code</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Unit Price</th>
                                <th>Effective Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tariffs as $tariff)
                                <tr>
                                    <td>{{ $tariff->service_code }}</td>
                                    <td>{{ $tariff->description }}</td>
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
                                    <td>GH₵ {{ number_format($tariff->unit_price, 2) }}</td>
                                    <td>{{ $tariff->effective_date ? $tariff->effective_date->format('M d, Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('tariffs.show', $tariff) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('tariffs.edit', $tariff) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('tariffs.destroy', $tariff) }}" method="POST" class="d-inline">
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
                    {{ $tariffs->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-list-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No tariffs found</h5>
                    <p class="text-muted">Get started by adding your first service tariff.</p>
                    <a href="{{ route('tariffs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Add Tariff
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
