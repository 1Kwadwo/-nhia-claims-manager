<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-hospital-user me-2"></i> Providers
            </h2>
            <a href="{{ route('providers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add Provider
            </a>
        </div>
    </x-slot>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Healthcare Providers</h6>
        </div>
        <div class="card-body">
            @if($providers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>NHIS Code</th>
                                <th>Region</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($providers as $provider)
                                <tr>
                                    <td>{{ $provider->name }}</td>
                                    <td>{{ $provider->nhis_code }}</td>
                                    <td>{{ $provider->region }}</td>
                                    <td>{{ $provider->phone }}</td>
                                    <td>
                                        <a href="{{ route('providers.show', $provider) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('providers.edit', $provider) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('providers.destroy', $provider) }}" method="POST" class="d-inline">
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
                    {{ $providers->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-hospital fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No providers found</h5>
                    <p class="text-muted">Get started by adding your first healthcare provider.</p>
                    <a href="{{ route('providers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Add Provider
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
