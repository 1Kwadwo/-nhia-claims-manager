<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Claim extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'claim_number',
        'provider_id',
        'beneficiary_id',
        'date_of_service',
        'visit_type',
        'diagnoses',
        'status',
        'total_cost',
        'notes',
    ];

    protected $casts = [
        'date_of_service' => 'date',
        'diagnoses' => 'array',
        'total_cost' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function claimItems(): HasMany
    {
        return $this->hasMany(ClaimItem::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function auditTrails(): HasMany
    {
        return $this->hasMany(AuditTrail::class, 'entity_id')->where('entity_type', 'Claim');
    }

    public static function generateClaimNumber(): string
    {
        $year = now()->format('Y');
        $month = now()->format('m');
        
        $lastClaim = self::where('claim_number', 'like', "CLM-{$year}{$month}-%")
            ->orderBy('claim_number', 'desc')
            ->first();

        if ($lastClaim) {
            $lastNumber = (int) substr($lastClaim->claim_number, -5);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return "CLM-{$year}{$month}-" . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function calculateTotalCost(): void
    {
        $this->total_cost = $this->claimItems()->sum('amount');
        $this->save();
    }

    public function canTransitionTo(string $newStatus): bool
    {
        $allowedTransitions = [
            'Draft' => ['Submitted'],
            'Submitted' => ['UnderReview'],
            'UnderReview' => ['Approved', 'Rejected'],
            'Approved' => ['Paid'],
            'Rejected' => [],
            'Paid' => [],
        ];

        return in_array($newStatus, $allowedTransitions[$this->status] ?? []);
    }

    public static function rules(): array
    {
        return [
            'provider_id' => 'required|exists:providers,id',
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'date_of_service' => 'required|date|before_or_equal:today',
            'visit_type' => 'required|in:OPD,IPD,Maternity,Referral',
            'diagnoses' => 'nullable|array',
            'status' => 'required|in:Draft,Submitted,UnderReview,Approved,Rejected,Paid',
            'notes' => 'nullable|string',
        ];
    }

    public static function updateRules($id): array
    {
        return [
            'provider_id' => 'required|exists:providers,id',
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'date_of_service' => 'required|date|before_or_equal:today',
            'visit_type' => 'required|in:OPD,IPD,Maternity,Referral',
            'diagnoses' => 'nullable|array',
            'status' => 'nullable|in:Draft,Submitted,UnderReview,Approved,Rejected,Paid',
            'notes' => 'nullable|string',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($claim) {
            if (empty($claim->claim_number)) {
                $claim->claim_number = self::generateClaimNumber();
            }
        });

        static::saved(function ($claim) {
            $claim->calculateTotalCost();
        });
    }
}
