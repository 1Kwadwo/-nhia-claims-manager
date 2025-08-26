<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tariff::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('service_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $tariffs = $query->orderBy('service_code')->paginate(15);
        
        return view('tariffs.index', compact('tariffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tariffs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Tariff::rules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tariff = Tariff::create($request->all());

        return redirect()->route('tariffs.index')
            ->with('success', 'Tariff created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tariff $tariff)
    {
        $claimItems = $tariff->claimItems()->with(['claim'])->paginate(10);
        
        return view('tariffs.show', compact('tariff', 'claimItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tariff $tariff)
    {
        return view('tariffs.edit', compact('tariff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tariff $tariff)
    {
        $validator = Validator::make($request->all(), Tariff::updateRules($tariff->id));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tariff->update($request->all());

        return redirect()->route('tariffs.index')
            ->with('success', 'Tariff updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tariff $tariff)
    {
        // Check if tariff is used in claim items
        if ($tariff->claimItems()->count() > 0) {
            return redirect()->route('tariffs.index')
                ->with('error', 'Cannot delete tariff that is used in claims.');
        }

        $tariff->delete();

        return redirect()->route('tariffs.index')
            ->with('success', 'Tariff deleted successfully.');
    }

    /**
     * Get tariff details for AJAX request (used in claim creation)
     */
    public function getTariffDetails(Request $request)
    {
        $serviceCode = $request->service_code;
        $tariff = Tariff::where('service_code', $serviceCode)->first();

        if ($tariff) {
            return response()->json([
                'success' => true,
                'tariff' => $tariff
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tariff not found'
        ]);
    }
}
