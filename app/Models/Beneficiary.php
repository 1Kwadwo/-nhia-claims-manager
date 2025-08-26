<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beneficiary extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nhis_number',
        'full_name',
        'date_of_birth',
        'sex',
        'scheme_type',
        'expiry_date',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'expiry_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public static function rules(): array
    {
        return [
            'nhis_number' => 'required|string|regex:/^[A-Za-z0-9]{10,15}$/|unique:beneficiaries,nhis_number',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'sex' => 'nullable|in:Male,Female,Other',
            'scheme_type' => 'required|in:NHIS,Private',
            'expiry_date' => 'nullable|date|after:today',
        ];
    }

    public static function updateRules($id): array
    {
        return [
            'nhis_number' => 'required|string|regex:/^[A-Za-z0-9]{10,15}$/|unique:beneficiaries,nhis_number,' . $id,
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'sex' => 'nullable|in:Male,Female,Other',
            'scheme_type' => 'required|in:NHIS,Private',
            'expiry_date' => 'nullable|date|after:today',
        ];
    }
}
