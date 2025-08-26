<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'claim_id',
        'file_path',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function claim(): BelongsTo
    {
        return $this->belongsTo(Claim::class);
    }

    public static function rules(): array
    {
        return [
            'claim_id' => 'required|exists:claims,id',
            'file_path' => 'required|string|max:255',
            'type' => 'required|in:Image,PDF,Other',
        ];
    }

    public static function updateRules($id): array
    {
        return [
            'claim_id' => 'required|exists:claims,id',
            'file_path' => 'required|string|max:255',
            'type' => 'required|in:Image,PDF,Other',
        ];
    }
}
