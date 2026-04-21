<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'unit_price'];

    protected $casts = [
        'unit_price' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the cart
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get item subtotal (dùng unit_price đã tính khi thêm vào)
     */
    public function getSubtotal()
    {
        return $this->unit_price * $this->quantity;
    }
}
