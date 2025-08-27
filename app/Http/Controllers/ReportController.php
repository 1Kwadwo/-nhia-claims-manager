<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Provider;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display the reports index page
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Generate claims summary report
     */
    public function claimsSummary(Request $request)
    {
        $query = Claim::with(['provider', 'beneficiary']);

        // Apply filters
        if ($request->filled('date_from')) {
            $query->where('date_of_service', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date_of_service', '<=', $request->date_to);
        }

        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $claims = $query->orderBy('date_of_service', 'desc')->get();

        // Calculate summary statistics
        $totalClaims = $claims->count();
        $totalAmount = $claims->sum('total_cost');
        $approvedClaims = $claims->where('status', 'Approved')->count();
        $pendingClaims = $claims->whereIn('status', ['Draft', 'Submitted', 'UnderReview'])->count();
        
        $summary = [
            'total_claims' => $totalClaims,
            'total_amount' => $totalAmount,
            'claims_by_status' => $claims->groupBy('status')->map->count(),
            'amount_by_status' => $claims->groupBy('status')->map->sum('total_cost'),
            'claims_by_provider' => $claims->groupBy('provider.name')->map->count(),
            'amount_by_provider' => $claims->groupBy('provider.name')->map->sum('total_cost'),
        ];

        $providers = Provider::orderBy('name')->get();

        return view('reports.claims-summary', compact('claims', 'summary', 'providers', 'totalClaims', 'totalAmount', 'approvedClaims', 'pendingClaims'));
    }

    /**
     * Generate provider performance report
     */
    public function providerPerformance(Request $request)
    {
        $query = Claim::with('provider');

        // Apply date filters
        if ($request->filled('date_from')) {
            $query->where('date_of_service', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date_of_service', '<=', $request->date_to);
        }

        $providerStats = $query->select(
                'provider_id',
                DB::raw('count(*) as total_claims'),
                DB::raw('sum(total_cost) as total_amount'),
                DB::raw('avg(total_cost) as avg_amount'),
                DB::raw('count(case when status = "Approved" then 1 end) as approved_claims'),
                DB::raw('count(case when status = "Rejected" then 1 end) as rejected_claims')
            )
            ->groupBy('provider_id')
            ->orderBy('total_claims', 'desc')
            ->get();

        // Load provider details and calculate stats
        $providerStats->load('provider');
        
        // Transform data for the view
        $providers = $providerStats->map(function ($stat) {
            return (object) [
                'name' => $stat->provider->name ?? 'Unknown Provider',
                'nhis_code' => $stat->provider->nhis_code ?? 'N/A',
                'region' => $stat->provider->region ?? 'N/A',
                'claims_count' => $stat->total_claims,
                'total_amount' => $stat->total_amount,
                'average_amount' => $stat->avg_amount,
                'approved_claims' => $stat->approved_claims,
                'rejected_claims' => $stat->rejected_claims,
            ];
        });

        return view('reports.provider-performance', compact('providers'));
    }

    /**
     * Generate beneficiary utilization report
     */
    public function beneficiaryUtilization(Request $request)
    {
        $query = Claim::with('beneficiary');

        // Apply date filters
        if ($request->filled('date_from')) {
            $query->where('date_of_service', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date_of_service', '<=', $request->date_to);
        }

        $beneficiaryStats = $query->select(
                'beneficiary_id',
                DB::raw('count(*) as total_claims'),
                DB::raw('sum(total_cost) as total_amount'),
                DB::raw('avg(total_cost) as avg_amount')
            )
            ->groupBy('beneficiary_id')
            ->orderBy('total_claims', 'desc')
            ->get();

        // Load beneficiary details and calculate stats
        $beneficiaryStats->load('beneficiary');
        
        // Transform data for the view
        $beneficiaries = $beneficiaryStats->map(function ($stat) {
            return (object) [
                'full_name' => $stat->beneficiary->full_name ?? 'Unknown Beneficiary',
                'nhis_number' => $stat->beneficiary->nhis_number ?? 'N/A',
                'scheme_type' => $stat->beneficiary->scheme_type ?? 'N/A',
                'claims_count' => $stat->total_claims,
                'total_amount' => $stat->total_amount,
                'average_amount' => $stat->avg_amount,
            ];
        });

        return view('reports.beneficiary-utilization', compact('beneficiaries'));
    }

    /**
     * Export claims summary to PDF
     */
    public function exportClaimsSummaryPdf(Request $request)
    {
        $query = Claim::with(['provider', 'beneficiary']);

        // Apply filters
        if ($request->filled('date_from')) {
            $query->where('date_of_service', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date_of_service', '<=', $request->date_to);
        }

        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $claims = $query->orderBy('date_of_service', 'desc')->get();

        // Calculate summary statistics
        $summary = [
            'total_claims' => $claims->count(),
            'total_amount' => $claims->sum('total_cost'),
            'claims_by_status' => $claims->groupBy('status')->map->count(),
            'amount_by_status' => $claims->groupBy('status')->map->sum('total_cost'),
        ];

        $pdf = \PDF::loadView('reports.pdf.claims-summary', compact('claims', 'summary'));
        
        return $pdf->download('claims-summary-report.pdf');
    }

    /**
     * Export claims summary to CSV
     */
    public function exportClaimsSummaryCsv(Request $request)
    {
        $query = Claim::with(['provider', 'beneficiary']);

        // Apply filters
        if ($request->filled('date_from')) {
            $query->where('date_of_service', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date_of_service', '<=', $request->date_to);
        }

        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $claims = $query->orderBy('date_of_service', 'desc')->get();

        $filename = 'claims-summary-report.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($claims) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, ['Claim Number', 'Provider', 'Beneficiary', 'Date of Service', 'Status', 'Total Cost']);
            
            // Data rows
            foreach ($claims as $claim) {
                fputcsv($file, [
                    $claim->claim_number,
                    $claim->provider->name,
                    $claim->beneficiary->full_name,
                    $claim->date_of_service->format('Y-m-d'),
                    $claim->status,
                    $claim->total_cost
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
