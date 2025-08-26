<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-chart-bar me-2"></i> Reports
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-file-medical fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Claims Summary</h5>
                    <p class="card-text">Generate comprehensive claims reports with filtering options.</p>
                    <a href="{{ route('reports.claims-summary') }}" class="btn btn-primary">
                        <i class="fas fa-chart-line me-2"></i> View Report
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-hospital-user fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Provider Performance</h5>
                    <p class="card-text">Analyze provider performance and claim statistics.</p>
                    <a href="{{ route('reports.provider-performance') }}" class="btn btn-success">
                        <i class="fas fa-chart-bar me-2"></i> View Report
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Beneficiary Utilization</h5>
                    <p class="card-text">Track beneficiary usage patterns and statistics.</p>
                    <a href="{{ route('reports.beneficiary-utilization') }}" class="btn btn-info">
                        <i class="fas fa-chart-pie me-2"></i> View Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Export Options</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Claims Summary Export</h6>
                            <p class="text-muted">Export claims data in various formats.</p>
                            <a href="{{ route('reports.claims-summary.export-pdf') }}" class="btn btn-outline-danger me-2">
                                <i class="fas fa-file-pdf me-2"></i> Export PDF
                            </a>
                            <a href="{{ route('reports.claims-summary.export-csv') }}" class="btn btn-outline-success">
                                <i class="fas fa-file-csv me-2"></i> Export CSV
                            </a>
                        </div>
                        <div class="col-md-6">
                            <h6>Report Features</h6>
                            <ul class="text-muted">
                                <li>Date range filtering</li>
                                <li>Status-based filtering</li>
                                <li>Provider-specific reports</li>
                                <li>Multiple export formats</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
