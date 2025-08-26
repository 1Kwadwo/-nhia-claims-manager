<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Provider;
use App\Models\Beneficiary;
use App\Models\Tariff;
use App\Models\ClaimItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Claim::with(['provider', 'beneficiary']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('claim_number', 'like', "%{$search}%")
                  ->orWhereHas('provider', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('beneficiary', function ($q) use ($search) {
                      $q->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by provider
        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('date_of_service', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date_of_service', '<=', $request->date_to);
        }

        $claims = $query->orderBy('created_at', 'desc')->paginate(15);
        $providers = Provider::orderBy('name')->get();
        
        return view('claims.index', compact('claims', 'providers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $providers = Provider::orderBy('name')->get();
        $beneficiaries = Beneficiary::orderBy('full_name')->get();
        $tariffs = Tariff::orderBy('service_code')->get();
        
        return view('claims.create', compact('providers', 'beneficiaries', 'tariffs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Process diagnoses field - convert text to array
        $data = $request->all();
        if ($request->has('diagnoses') && !empty($request->diagnoses)) {
            // Split by newlines and filter out empty lines
            $diagnoses = array_filter(
                array_map('trim', explode("\n", $request->diagnoses)),
                function($line) { return !empty($line); }
            );
            $data['diagnoses'] = $diagnoses;
        } else {
            $data['diagnoses'] = null;
        }

        // Set default status for new claims
        $data['status'] = 'Draft';

        $validator = Validator::make($data, Claim::rules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $claim = Claim::create($data);

            // Create claim items
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    ClaimItem::create([
                        'claim_id' => $claim->id,
                        'service_code' => $item['service_code'] ?? null,
                        'description' => $item['description'],
                        'category' => $item['category'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                    ]);
                }
            }

            DB::commit();

            // Log successful creation
            \Log::info('Claim created successfully: ' . $claim->id);

            return redirect()->route('claims.show', $claim)
                ->with('success', 'Claim created successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error creating claim: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Claim $claim)
    {
        try {
            $claim->load(['provider', 'beneficiary', 'claimItems.tariff', 'attachments', 'auditTrails']);
            
            return view('claims.show', compact('claim'));
        } catch (\Exception $e) {
            // Log the error and redirect with error message
            \Log::error('Error showing claim: ' . $e->getMessage());
            return redirect()->route('claims.index')
                ->with('error', 'Error displaying claim: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Claim $claim)
    {
        if ($claim->status !== 'Draft') {
            return redirect()->route('claims.show', $claim)
                ->with('error', 'Only draft claims can be edited.');
        }

        $providers = Provider::orderBy('name')->get();
        $beneficiaries = Beneficiary::orderBy('full_name')->get();
        $tariffs = Tariff::orderBy('service_code')->get();
        
        return view('claims.edit', compact('claim', 'providers', 'beneficiaries', 'tariffs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Claim $claim)
    {
        if ($claim->status !== 'Draft') {
            return redirect()->route('claims.show', $claim)
                ->with('error', 'Only draft claims can be edited.');
        }

        // Process diagnoses field - convert text to array
        $data = $request->all();
        if ($request->has('diagnoses') && !empty($request->diagnoses)) {
            // Split by newlines and filter out empty lines
            $diagnoses = array_filter(
                array_map('trim', explode("\n", $request->diagnoses)),
                function($line) { return !empty($line); }
            );
            $data['diagnoses'] = $diagnoses;
        } else {
            $data['diagnoses'] = null;
        }

        // Preserve existing status for updates
        $data['status'] = $claim->status;

        $validator = Validator::make($data, Claim::updateRules($claim->id));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $claim->update($data);

            // Update claim items
            if ($request->has('items')) {
                // Delete existing items
                $claim->claimItems()->delete();

                // Create new items
                foreach ($request->items as $item) {
                    ClaimItem::create([
                        'claim_id' => $claim->id,
                        'service_code' => $item['service_code'] ?? null,
                        'description' => $item['description'],
                        'category' => $item['category'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('claims.show', $claim)
                ->with('success', 'Claim updated successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error updating claim: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Claim $claim)
    {
        if ($claim->status !== 'Draft') {
            return redirect()->route('claims.index')
                ->with('error', 'Only draft claims can be deleted.');
        }

        $claim->delete();

        return redirect()->route('claims.index')
            ->with('success', 'Claim deleted successfully.');
    }

    /**
     * Update claim status
     */
    public function updateStatus(Request $request, Claim $claim)
    {
        $newStatus = $request->status;

        if (!$claim->canTransitionTo($newStatus)) {
            return redirect()->back()
                ->with('error', 'Invalid status transition.');
        }

        $oldStatus = $claim->status;
        $claim->update(['status' => $newStatus]);

        return redirect()->back()
            ->with('success', "Claim status updated from {$oldStatus} to {$newStatus}.");
    }

    /**
     * Export claim to PDF
     */
    public function exportPdf(Claim $claim)
    {
        $claim->load(['provider', 'beneficiary', 'claimItems.tariff']);
        
        $pdf = \PDF::loadView('claims.pdf', compact('claim'));
        
        return $pdf->download("claim-{$claim->claim_number}.pdf");
    }

    /**
     * Export claim to CSV
     */
    public function exportCsv(Claim $claim)
    {
        $claim->load(['provider', 'beneficiary', 'claimItems.tariff']);
        
        $filename = "claim-{$claim->claim_number}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($claim) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, ['Claim Number', 'Provider', 'Beneficiary', 'Date of Service', 'Status', 'Total Cost']);
            
            // Data row
            fputcsv($file, [
                $claim->claim_number,
                $claim->provider->name,
                $claim->beneficiary->full_name,
                $claim->date_of_service->format('Y-m-d'),
                $claim->status,
                $claim->total_cost
            ]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
