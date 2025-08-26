<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-plus me-2"></i> Add Tariff
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Service Tariff Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tariffs.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="service_code" class="form-label">Service Code *</label>
                            <input type="text" class="form-control @error('service_code') is-invalid @enderror" 
                                   id="service_code" name="service_code" value="{{ old('service_code') }}" 
                                   placeholder="Enter unique service code" required>
                            @error('service_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" 
                                   id="description" name="description" value="{{ old('description') }}" 
                                   placeholder="Enter service description" required>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category *</label>
                                    <select class="form-control @error('category') is-invalid @enderror" 
                                            id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="Consultation" {{ old('category') == 'Consultation' ? 'selected' : '' }}>Consultation</option>
                                        <option value="Lab" {{ old('category') == 'Lab' ? 'selected' : '' }}>Lab</option>
                                        <option value="Drug" {{ old('category') == 'Drug' ? 'selected' : '' }}>Drug</option>
                                        <option value="Procedure" {{ old('category') == 'Procedure' ? 'selected' : '' }}>Procedure</option>
                                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="unit_price" class="form-label">Unit Price (GH₵) *</label>
                                    <input type="number" step="0.01" min="0" class="form-control @error('unit_price') is-invalid @enderror" 
                                           id="unit_price" name="unit_price" value="{{ old('unit_price') }}" 
                                           placeholder="0.00" required>
                                    @error('unit_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="effective_date" class="form-label">Effective Date</label>
                            <input type="date" class="form-control @error('effective_date') is-invalid @enderror" 
                                   id="effective_date" name="effective_date" value="{{ old('effective_date') }}">
                            @error('effective_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tariffs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Save Tariff
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
