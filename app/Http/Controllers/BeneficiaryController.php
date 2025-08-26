<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Beneficiary::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nhis_number', 'like', "%{$search}%");
            });
        }

        // Filter by scheme type
        if ($request->filled('scheme_type')) {
            $query->where('scheme_type', $request->scheme_type);
        }

        $beneficiaries = $query->orderBy('full_name')->paginate(15);
        
        return view('beneficiaries.index', compact('beneficiaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('beneficiaries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Beneficiary::rules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $beneficiary = Beneficiary::create($request->all());

        return redirect()->route('beneficiaries.index')
            ->with('success', 'Beneficiary created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Beneficiary $beneficiary)
    {
        $claims = $beneficiary->claims()->with(['provider'])->paginate(10);
        
        return view('beneficiaries.show', compact('beneficiary', 'claims'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beneficiary $beneficiary)
    {
        return view('beneficiaries.edit', compact('beneficiary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beneficiary $beneficiary)
    {
        $validator = Validator::make($request->all(), Beneficiary::updateRules($beneficiary->id));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $beneficiary->update($request->all());

        return redirect()->route('beneficiaries.index')
            ->with('success', 'Beneficiary updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beneficiary $beneficiary)
    {
        // Check if beneficiary has claims
        if ($beneficiary->claims()->count() > 0) {
            return redirect()->route('beneficiaries.index')
                ->with('error', 'Cannot delete beneficiary with existing claims.');
        }

        $beneficiary->delete();

        return redirect()->route('beneficiaries.index')
            ->with('success', 'Beneficiary deleted successfully.');
    }
}
