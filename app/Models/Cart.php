<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the cart
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get cart items
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get products in cart
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_items')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    /**
     * Calculate cart total
     */
    public function getTotal()
    {
        return $this->items()->get()
                            ->sum(function ($item) {
                                return $item->getSubtotal();
                            });
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        return $this->items()->delete();
    }
}
