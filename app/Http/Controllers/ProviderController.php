<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Provider::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nhis_code', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%");
            });
        }

        $providers = $query->orderBy('name')->paginate(15);
        
        return view('providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('providers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Provider::rules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $provider = Provider::create($request->all());

        return redirect()->route('providers.index')
            ->with('success', 'Provider created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider)
    {
        $claims = $provider->claims()->with(['beneficiary'])->paginate(10);
        
        return view('providers.show', compact('provider', 'claims'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provider $provider)
    {
        $validator = Validator::make($request->all(), Provider::updateRules($provider->id));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $provider->update($request->all());

        return redirect()->route('providers.index')
            ->with('success', 'Provider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        // Check if provider has claims
        if ($provider->claims()->count() > 0) {
            return redirect()->route('providers.index')
                ->with('error', 'Cannot delete provider with existing claims.');
        }

        $provider->delete();

        return redirect()->route('providers.index')
            ->with('success', 'Provider deleted successfully.');
    }
}
