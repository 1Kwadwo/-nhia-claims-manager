<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-hospital me-2"></i>
            NHIA Claims Manager
        </a>

        <!-- Hamburger -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('claims.*') ? 'active' : '' }}" href="{{ route('claims.index') }}">
                        <i class="fas fa-file-medical me-1"></i> Claims
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('providers.*') ? 'active' : '' }}" href="{{ route('providers.index') }}">
                        <i class="fas fa-hospital-user me-1"></i> Providers
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('beneficiaries.*') ? 'active' : '' }}" href="{{ route('beneficiaries.index') }}">
                        <i class="fas fa-users me-1"></i> Beneficiaries
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tariffs.*') ? 'active' : '' }}" href="{{ route('tariffs.index') }}">
                        <i class="fas fa-list-alt me-1"></i> Tariffs
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-chart-bar me-1"></i> Reports
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('reports.index') }}">Reports Overview</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.claims-summary') }}">Claims Summary</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.provider-performance') }}">Provider Performance</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.beneficiary-utilization') }}">Beneficiary Utilization</a></li>
                    </ul>
                </li>
            </ul>

            <!-- User Menu -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-edit me-1"></i> Profile
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-1"></i> Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
