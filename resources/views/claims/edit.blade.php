<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-edit me-2"></i> Edit Claim
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Claim Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('claims.update', $claim) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="provider_id" class="form-label">Provider *</label>
                                    <select class="form-control @error('provider_id') is-invalid @enderror" 
                                            id="provider_id" name="provider_id" required>
                                        <option value="">Select Provider</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}" {{ old('provider_id', $claim->provider_id) == $provider->id ? 'selected' : '' }}>
                                                {{ $provider->name }} ({{ $provider->nhis_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('provider_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="beneficiary_id" class="form-label">Beneficiary *</label>
                                    <select class="form-control @error('beneficiary_id') is-invalid @enderror" 
                                            id="beneficiary_id" name="beneficiary_id" required>
                                        <option value="">Select Beneficiary</option>
                                        @foreach($beneficiaries as $beneficiary)
                                            <option value="{{ $beneficiary->id }}" {{ old('beneficiary_id', $claim->beneficiary_id) == $beneficiary->id ? 'selected' : '' }}>
                                                {{ $beneficiary->full_name }} ({{ $beneficiary->nhis_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('beneficiary_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_of_service" class="form-label">Date of Service *</label>
                                    <input type="date" class="form-control @error('date_of_service') is-invalid @enderror" 
                                           id="date_of_service" name="date_of_service" 
                                           value="{{ old('date_of_service', $claim->date_of_service->format('Y-m-d')) }}" required>
                                    @error('date_of_service')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="visit_type" class="form-label">Visit Type *</label>
                                    <select class="form-control @error('visit_type') is-invalid @enderror" 
                                            id="visit_type" name="visit_type" required>
                                        <option value="">Select Visit Type</option>
                                        <option value="OPD" {{ old('visit_type', $claim->visit_type) == 'OPD' ? 'selected' : '' }}>OPD</option>
                                        <option value="IPD" {{ old('visit_type', $claim->visit_type) == 'IPD' ? 'selected' : '' }}>IPD</option>
                                        <option value="Maternity" {{ old('visit_type', $claim->visit_type) == 'Maternity' ? 'selected' : '' }}>Maternity</option>
                                        <option value="Referral" {{ old('visit_type', $claim->visit_type) == 'Referral' ? 'selected' : '' }}>Referral</option>
                                    </select>
                                    @error('visit_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="diagnoses" class="form-label">Diagnoses</label>
                            <textarea class="form-control @error('diagnoses') is-invalid @enderror" 
                                      id="diagnoses" name="diagnoses" rows="3" placeholder="Enter diagnoses (one per line)">{{ old('diagnoses', is_array($claim->diagnoses) ? implode("\n", $claim->diagnoses) : $claim->diagnoses) }}</textarea>
                            @error('diagnoses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes', $claim->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('claims.show', $claim) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Claim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
