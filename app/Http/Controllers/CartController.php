<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Show cart page
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng');
        }

        $cart = Auth::user()->cart;
        $items = $cart->items()->with('product')->get();
        $total = $cart->getTotal();

        return view('cart.index', compact('cart', 'items', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, int $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
        }

        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        // Get or create cart for user
        $cart = Auth::user()->cart;
        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }

        // Calculate unit price based on product type
        $unitPrice = $product->price; // Default (TOTO sản phẩm)
        
        // Nếu là gạch (có kích thước), tính giá/viên dựa trên diện tích 1 viên
        if ($product->size && $product->brand && $product->brand->slug !== 'toto') {
            // Parse size format: "60×90" hoặc "60x90" để lấy diện tích mỗi viên (m²)
            preg_match('/(\d+)\s*[×x]\s*(\d+)/', $product->size, $matches);
            if ($matches) {
                $width = intval($matches[1]) / 100; // Convert cm to m
                $height = intval($matches[2]) / 100;
                $tileSizeM2 = $width * $height;
                
                // unit_price = giá/viên = diện tích 1 viên × đơn giá/m²
                // (không nhân quantity - quantity sẽ được nhân sau khi lưu)
                $unitPrice = intval($tileSizeM2 * $product->price);
            }
        }

        // Check if product already in cart
        $cartItem = $cart->items()->where('product_id', $id)->first();

        if ($cartItem) {
            // Update quantity and unit price (recalculate)
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity,
                'unit_price' => $unitPrice
            ]);
        } else {
            // Add new item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
            ]);
        }

        return redirect()->back()->with('success', "Thêm {$product->name} vào giỏ hàng thành công!");
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, int $itemId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItem = CartItem::findOrFail($itemId);
        
        // Check if item belongs to user's cart
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $quantity = $request->input('quantity', 1);

        if ($quantity <= 0) {
            $cartItem->delete();
            return response()->json(['success' => true, 'message' => 'Xóa khỏi giỏ hàng thành công']);
        }

        $cartItem->update(['quantity' => $quantity]);
        return response()->json(['success' => true, 'message' => 'Cập nhật giỏ hàng thành công']);
    }

    /**
     * Remove item from cart
     */
    public function remove(int $itemId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItem = CartItem::findOrFail($itemId);
        
        // Check if item belongs to user's cart
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cartItem->delete();
        return redirect()->back()->with('success', 'Xóa khỏi giỏ hàng thành công');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = Auth::user()->cart;
        if ($cart) {
            $cart->clear();
        }

        return redirect()->back()->with('success', 'Đã xóa tất cả sản phẩm khỏi giỏ hàng');
    }

    /**
     * Get cart count (AJAX)
     */
    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Auth::user()->cart->items()->sum('quantity');
        return response()->json(['count' => $count]);
    }
}
