<?php

namespace App\Models;

use App\Enums\MerchantStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchantProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_description',
        'business_address',
        'business_phone',
        'business_email',
        'logo',
        'status',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'subscription_plan_id',
        'payment_proof',
        'payment_reference',
        'amount_paid',
    ];

    protected function casts(): array
    {
        return [
            'status' => MerchantStatus::class,
            'approved_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function isApproved(): bool
    {
        return $this->status === MerchantStatus::Approved;
    }

    public function isPending(): bool
    {
        return $this->status === MerchantStatus::Pending;
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', MerchantStatus::Pending);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', MerchantStatus::Approved);
    }
}
