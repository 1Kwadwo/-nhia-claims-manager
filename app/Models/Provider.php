<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'nhis_code',
        'region',
        'phone',
        'address',
    ];

    protected $casts = [
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
            'name' => 'required|string|max:255|unique:providers,name',
            'nhis_code' => 'required|string|max:255|unique:providers,nhis_code',
            'region' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ];
    }

    public static function updateRules($id): array
    {
        return [
            'name' => 'required|string|max:255|unique:providers,name,' . $id,
            'nhis_code' => 'required|string|max:255|unique:providers,nhis_code,' . $id,
            'region' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ];
    }
}
