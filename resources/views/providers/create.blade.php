<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-plus me-2"></i> Add Provider
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Provider Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('providers.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Provider Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nhis_code" class="form-label">NHIS Code *</label>
                            <input type="text" class="form-control @error('nhis_code') is-invalid @enderror" 
                                   id="nhis_code" name="nhis_code" value="{{ old('nhis_code') }}" required>
                            @error('nhis_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="region" class="form-label">Region</label>
                            <select class="form-control @error('region') is-invalid @enderror" id="region" name="region">
                                <option value="">Select Region</option>
                                <option value="Greater Accra" {{ old('region') == 'Greater Accra' ? 'selected' : '' }}>Greater Accra</option>
                                <option value="Ashanti" {{ old('region') == 'Ashanti' ? 'selected' : '' }}>Ashanti</option>
                                <option value="Western" {{ old('region') == 'Western' ? 'selected' : '' }}>Western</option>
                                <option value="Central" {{ old('region') == 'Central' ? 'selected' : '' }}>Central</option>
                                <option value="Eastern" {{ old('region') == 'Eastern' ? 'selected' : '' }}>Eastern</option>
                                <option value="Volta" {{ old('region') == 'Volta' ? 'selected' : '' }}>Volta</option>
                                <option value="Northern" {{ old('region') == 'Northern' ? 'selected' : '' }}>Northern</option>
                                <option value="Upper East" {{ old('region') == 'Upper East' ? 'selected' : '' }}>Upper East</option>
                                <option value="Upper West" {{ old('region') == 'Upper West' ? 'selected' : '' }}>Upper West</option>
                            </select>
                            @error('region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('providers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Save Provider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
