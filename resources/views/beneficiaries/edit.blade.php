<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-edit me-2"></i> Edit Beneficiary
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Beneficiary Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('beneficiaries.update', $beneficiary) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nhis_number" class="form-label">NHIS Number *</label>
                            <input type="text" class="form-control @error('nhis_number') is-invalid @enderror" 
                                   id="nhis_number" name="nhis_number" value="{{ old('nhis_number', $beneficiary->nhis_number) }}" 
                                   placeholder="Enter 10-15 character NHIS number" required>
                            @error('nhis_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" name="full_name" value="{{ old('full_name', $beneficiary->full_name) }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                           id="date_of_birth" name="date_of_birth" 
                                           value="{{ old('date_of_birth', $beneficiary->date_of_birth ? $beneficiary->date_of_birth->format('Y-m-d') : '') }}">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sex" class="form-label">Sex</label>
                                    <select class="form-control @error('sex') is-invalid @enderror" id="sex" name="sex">
                                        <option value="">Select Sex</option>
                                        <option value="Male" {{ old('sex', $beneficiary->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('sex', $beneficiary->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('sex', $beneficiary->sex) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('sex')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="scheme_type" class="form-label">Scheme Type *</label>
                                    <select class="form-control @error('scheme_type') is-invalid @enderror" 
                                            id="scheme_type" name="scheme_type" required>
                                        <option value="">Select Scheme Type</option>
                                        <option value="NHIS" {{ old('scheme_type', $beneficiary->scheme_type) == 'NHIS' ? 'selected' : '' }}>NHIS</option>
                                        <option value="Private" {{ old('scheme_type', $beneficiary->scheme_type) == 'Private' ? 'selected' : '' }}>Private</option>
                                    </select>
                                    @error('scheme_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expiry_date" class="form-label">Expiry Date</label>
                                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                           id="expiry_date" name="expiry_date" 
                                           value="{{ old('expiry_date', $beneficiary->expiry_date ? $beneficiary->expiry_date->format('Y-m-d') : '') }}">
                                    @error('expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Beneficiary
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
