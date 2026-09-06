<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'phone',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // All repairs booked by this customer
    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }

    // All repairs assigned to this user as a technician
    public function assignedRepairs(): HasMany
    {
        return $this->hasMany(Repair::class, 'technician_id');
    }

    public function isAdmin(): bool
    {
        return $this->role?->slug === 'admin';
    }

    public function isTechnician(): bool
    {
        return $this->role?->slug === 'technician';
    }
}