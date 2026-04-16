<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'delivery_address',
        'phone',
        'notes',
        'payment_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get user who placed the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get order items
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get payment for order
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Check if order is completed
     */
    public function isCompleted()
    {
        return $this->status === 'delivered';
    }

    /**
     * Cancel order
     */
    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }

    /**
     * Update status
     */
    public function updateStatus($status)
    {
        return $this->update(['status' => $status]);
    }
}
