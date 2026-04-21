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
        'packed_at',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'packed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
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

    /**
     * Check if order has sufficient stock for all items
     */
    public function hasEnoughStock()
    {
        $items = $this->items()->with('product')->get();
        
        foreach ($items as $item) {
            if (!$item->product) {
                return false;
            }
            if ($item->product->quantity < $item->quantity) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get out of stock items
     */
    public function getOutOfStockItems()
    {
        $outOfStock = [];
        $items = $this->items()->with('product')->get();
        
        foreach ($items as $item) {
            if ($item->product->quantity < $item->quantity) {
                $outOfStock[] = [
                    'product' => $item->product->name,
                    'needed' => $item->quantity,
                    'available' => $item->product->quantity,
                ];
            }
        }
        
        return $outOfStock;
    }

    /**
     * Deduct stock for confirmed order
     */
    public function deductStock()
    {
        $items = $this->items()->with('product')->get();
        
        foreach ($items as $item) {
            $product = $item->product;
            $product->decrement('quantity', $item->quantity);
            
            // Log the stock deduction
            InventoryLog::logAction(
                $product->id,
                'sale',
                -$item->quantity,
                $this->id,
                "Đơn hàng #{$this->id}",
                auth()->id()
            );
        }
    }

    /**
     * Restore stock for cancelled order
     */
    public function restoreStock()
    {
        $items = $this->items()->with('product')->get();
        
        foreach ($items as $item) {
            $product = $item->product;
            $product->increment('quantity', $item->quantity);
            
            // Log the stock restoration
            InventoryLog::logAction(
                $product->id,
                'return',
                $item->quantity,
                $this->id,
                "Hủy đơn hàng #{$this->id}",
                auth()->id()
            );
        }
    }
}
