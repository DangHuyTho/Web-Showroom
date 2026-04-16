<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'transaction_id',
        'amount',
        'payment_method',
        'status',
        'response_data',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed()
    {
        $this->update(['status' => 'failed']);
    }
}
