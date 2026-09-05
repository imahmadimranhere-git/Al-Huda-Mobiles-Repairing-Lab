<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repair extends Model
{
    protected $fillable = [
        'tracking_id',
        'user_id',
        'device_brand',
        'device_model',
        'issue',
        'diagnosis',
        'estimated_cost',
        'final_cost',
        'status',
    ];

    // The customer this repair belongs to
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Full timeline of status changes for this repair
    public function statusHistories(): HasMany
    {
        return $this->hasMany(RepairStatusHistory::class);
    }
}