<?php

namespace App\Models;

use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'status',
        'starts_at',
        'expires_at',
        'activated_at',
        'activated_by',
        'admin_notes',
    ];

    protected $casts = [
        'status' => SubscriptionStatus::class,
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'activated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function activatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'activated_by');
    }

    public function isActive(): bool
    {
        return $this->status === SubscriptionStatus::Active
            && $this->expires_at->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast()
            || $this->status === SubscriptionStatus::Expired;
    }

    public function daysRemaining(): int
    {
        if ($this->expires_at->isPast()) {
            return 0;
        }

        return (int) now()->diffInDays($this->expires_at, false);
    }

    public function scopeActive($query)
    {
        return $query->where('status', SubscriptionStatus::Active->value)
            ->where('expires_at', '>', now());
    }

    public function scopePremiumActive($query)
    {
        return $query->where('status', SubscriptionStatus::Active->value)
            ->where('expires_at', '>', now())
            ->whereHas('plan', fn ($q) => $q->where('is_premium', true));
    }

    public function scopeExpired($query)
    {
        return $query->where(function ($q) {
            $q->where('status', SubscriptionStatus::Expired->value)
                ->orWhere('expires_at', '<=', now());
        });
    }
}
