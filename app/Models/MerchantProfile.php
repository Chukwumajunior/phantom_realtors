<?php

namespace App\Models;

use App\Enums\MerchantStatus;
use App\Enums\PosterTier;
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
        'tier',
        'company_name',
        'cac_document',
        'payment_proof',
        'payment_reference',
        'nin',
        'house_number',
        'street_name',
        'area',
        'lga',
        'state',
        'zip_code',
        'country',
    ];

    protected function casts(): array
    {
        return [
            'status' => MerchantStatus::class,
            'tier' => PosterTier::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved(): bool
    {
        return $this->status === MerchantStatus::Approved;
    }

    public function isPending(): bool
    {
        return $this->status === MerchantStatus::Pending;
    }

    /**
     * Get the full formatted address.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->house_number,
            $this->street_name,
            $this->area,
            $this->lga,
            $this->state,
            $this->country,
        ]);

        return implode(', ', $parts);
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

    public function scopeOfTier($query, PosterTier $tier)
    {
        return $query->where('tier', $tier);
    }
}
