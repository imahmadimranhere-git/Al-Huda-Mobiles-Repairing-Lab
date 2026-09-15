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
        'customer_name',
        'customer_phone',
        'delivery_method',
        'technician_id',
        'approval_email',
        'otp_code',
        'otp_expires_at',
        'approved_at',
        'disclaimer_accepted_at',
        'device_brand',
        'device_model',
        'issue',
        'device_photo',
        'diagnosis',
        'estimated_cost',
        'final_cost',
        'status',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'approved_at' => 'datetime',
        'disclaimer_accepted_at' => 'datetime',
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

    public function delivery(): HasOne
    {
        return $this->hasOne(RepairDelivery::class);
    }

    public function needsApproval(): bool
    {
        return ! is_null($this->approval_email);
    }

    public function isApproved(): bool
    {
        return ! is_null($this->approved_at);
    }

    public function deliveryMethodLabel(): string
    {
        return match ($this->delivery_method) {
            'courier' => 'Courier / Pickup Requested',
            default => 'Drop-off at Shop',
        };
    }
}