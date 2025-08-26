<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tariff extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'service_code',
        'description',
        'category',
        'unit_price',
        'effective_date',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'effective_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function claimItems(): HasMany
    {
        return $this->hasMany(ClaimItem::class, 'service_code', 'service_code');
    }

    public static function rules(): array
    {
        return [
            'service_code' => 'required|string|max:255|unique:tariffs,service_code',
            'description' => 'required|string|max:255',
            'category' => 'required|in:Consultation,Lab,Drug,Procedure,Other',
            'unit_price' => 'required|numeric|min:0',
            'effective_date' => 'nullable|date',
        ];
    }

    public static function updateRules($id): array
    {
        return [
            'service_code' => 'required|string|max:255|unique:tariffs,service_code,' . $id,
            'description' => 'required|string|max:255',
            'category' => 'required|in:Consultation,Lab,Drug,Procedure,Other',
            'unit_price' => 'required|numeric|min:0',
            'effective_date' => 'nullable|date',
        ];
    }
}
