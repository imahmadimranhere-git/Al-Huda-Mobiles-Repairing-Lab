<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairDelivery extends Model
{
    protected $fillable = [
        'repair_id',
        'photo',
        'disclaimer_accepted',
    ];

    protected $casts = [
        'disclaimer_accepted' => 'boolean',
    ];

    public function repair(): BelongsTo
    {
        return $this->belongsTo(Repair::class);
    }
}