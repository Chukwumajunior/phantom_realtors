<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'payment_method',
        'payment_status',
        'reference_number',
        'bank_name',
        'account_name',
        'proof_of_payment',
        'notes',
        'confirmed_by',
        'confirmed_at',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'payment_method' => PaymentMethod::class,
            'payment_status' => PaymentStatus::class,
            'amount' => 'decimal:2',
            'confirmed_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function isPending(): bool
    {
        return $this->payment_status === PaymentStatus::Pending;
    }

    public function isConfirmed(): bool
    {
        return $this->payment_status === PaymentStatus::Confirmed;
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('payment_status', PaymentStatus::Pending);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('payment_status', PaymentStatus::Confirmed);
    }
}
