<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Provider;
use App\Models\Beneficiary;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get basic statistics
        $totalClaims = Claim::count();
        $totalProviders = Provider::count();
        $totalBeneficiaries = Beneficiary::count();
        $totalTariffs = Tariff::count();

        // Get claims by status
        $claimsByStatus = Claim::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Get total amounts by status
        $amountsByStatus = Claim::select('status', DB::raw('sum(total_cost) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        // Get monthly claims data for chart - using SQLite compatible functions
        $monthlyClaims = Claim::select(
                DB::raw('strftime("%Y-%m", created_at) as month'),
                DB::raw('count(*) as count'),
                DB::raw('sum(total_cost) as total_amount')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get claims per provider
        $claimsPerProvider = Claim::with('provider')
            ->select('provider_id', DB::raw('count(*) as count'))
            ->groupBy('provider_id')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalClaims',
            'totalProviders',
            'totalBeneficiaries',
            'totalTariffs',
            'claimsByStatus',
            'amountsByStatus',
            'monthlyClaims',
            'claimsPerProvider'
        ));
    }
}
