<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'quantity_changed',
        'action_type',
        'reference_id',
        'notes',
        'quantity_before',
        'quantity_after',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product for this log
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who made the change
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create log entry for stock action
     */
    public static function logAction($productId, $actionType, $quantityChanged, $refId = null, $notes = null, $userId = null)
    {
        $product = Product::findOrFail($productId);
        $quantityBefore = $product->quantity;
        $quantityAfter = $quantityBefore + $quantityChanged;

        return self::create([
            'product_id' => $productId,
            'user_id' => $userId ?? auth()->id(),
            'quantity_changed' => $quantityChanged,
            'action_type' => $actionType,
            'reference_id' => $refId,
            'notes' => $notes,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
        ]);
    }
}
