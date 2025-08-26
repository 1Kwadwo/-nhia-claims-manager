<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClaimItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'claim_id',
        'service_code',
        'description',
        'category',
        'quantity',
        'unit_price',
        'amount',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function claim(): BelongsTo
    {
        return $this->belongsTo(Claim::class);
    }

    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class, 'service_code', 'service_code');
    }

    public function calculateAmount(): void
    {
        $this->amount = $this->quantity * $this->unit_price;
    }

    public static function rules(): array
    {
        return [
            'claim_id' => 'required|exists:claims,id',
            'service_code' => 'nullable|exists:tariffs,service_code',
            'description' => 'required|string|max:255',
            'category' => 'required|in:Consultation,Lab,Drug,Procedure,Other',
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0',
        ];
    }

    public static function updateRules($id): array
    {
        return [
            'claim_id' => 'required|exists:claims,id',
            'service_code' => 'nullable|exists:tariffs,service_code',
            'description' => 'required|string|max:255',
            'category' => 'required|in:Consultation,Lab,Drug,Procedure,Other',
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($claimItem) {
            $claimItem->calculateAmount();
        });

        static::saved(function ($claimItem) {
            $claimItem->claim->calculateTotalCost();
        });
    }
}
