<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Repair extends Model
{
    protected $fillable = [
        'tracking_id',
        'user_id',
        'technician_id',
        'approval_email',
        'otp_code',
        'otp_expires_at',
        'approved_at',
        'device_brand',
        'device_model',
        'issue',
        'diagnosis',
        'estimated_cost',
        'final_cost',
        'status',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(RepairStatusHistory::class);
    }

    // The customer's "device received" confirmation, if submitted
    public function delivery(): HasOne
    {
        return $this->hasOne(RepairDelivery::class);
    }

    // Only walk-ins with an approval_email need this step at all
    public function needsApproval(): bool
    {
        return ! is_null($this->approval_email);
    }

    public function isApproved(): bool
    {
        return ! is_null($this->approved_at);
    }
}