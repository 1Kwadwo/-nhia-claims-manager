<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'entity_type',
        'entity_id',
        'action',
        'before_json',
        'after_json',
        'timestamp',
    ];

    protected $casts = [
        'before_json' => 'array',
        'after_json' => 'array',
        'timestamp' => 'datetime',
    ];

    public $timestamps = false;

    public static function log(string $entityType, string $entityId, string $action, $before = null, $after = null): void
    {
        self::create([
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'action' => $action,
            'before_json' => $before,
            'after_json' => $after,
            'timestamp' => now(),
        ]);
    }

    public static function rules(): array
    {
        return [
            'entity_type' => 'required|string|max:255',
            'entity_id' => 'required|string|max:255',
            'action' => 'required|string|max:255',
            'before_json' => 'nullable|array',
            'after_json' => 'nullable|array',
        ];
    }
}
