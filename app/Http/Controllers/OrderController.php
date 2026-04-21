<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Show user's order list
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::findOrFail($id);
        
        // Check authorization
        if ($order->user_id !== Auth::id()) {
            return abort(403, 'Unauthorized');
        }

        $items = $order->items()->with('product')->get();

        return view('orders.show', compact('order', 'items'));
    }

    /**
     * Show checkout page
     */
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán');
        }

        $cart = Auth::user()->cart;
        $items = $cart->items()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
        }

        $total = $cart->getTotal();

        return view('orders.checkout', compact('cart', 'items', 'total'));
    }

    /**
     * Store order from cart
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'delivery_address' => 'required|string',
            'phone' => 'required|string|regex:/^[0-9\-\+\(\)\s]+$/',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:direct_payment,banking,credit_card,e_wallet',
        ], [
            'delivery_address.required' => 'Vui lòng nhập địa chỉ giao hàng',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
        ]);

        $cart = Auth::user()->cart;
        $cartItems = $cart->items()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
        }

        // Calculate total
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        try {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'pending',
                'delivery_address' => $validated['delivery_address'],
                'phone' => $validated['phone'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);
            }

            // Create payment
            $payment = Payment::create([
                'order_id' => $order->id,
                'transaction_id' => 'TXN-' . Str::random(12),
                'amount' => $total,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
            ]);

            $order->update(['payment_id' => $payment->id]);

            // Clear cart
            $cart->clear();

            return redirect()->route('orders.payment', $payment->id)
                ->with('success', 'Đặt hàng thành công! Vui lòng tiến hành thanh toán');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi khi tạo đơn hàng. Vui lòng thử lại');
        }
    }

    /**
     * Store order directly from product page (buy now)
     */
    public function storeDirect(Request $request, $productId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Vui lòng đăng nhập'], 401);
        }

        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'quantity' => 'required|numeric|min:1',
            'delivery_address' => 'required|string',
            'phone' => 'required|string|regex:/^[0-9\-\+\(\)\s]+$/',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:direct_payment,banking,credit_card,e_wallet',
        ], [
            'quantity.required' => 'Vui lòng nhập số lượng',
            'quantity.numeric' => 'Số lượng phải là số',
            'quantity.min' => 'Số lượng phải lớn hơn 0',
            'delivery_address.required' => 'Vui lòng nhập địa chỉ giao hàng',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
        ]);

        $quantity = intval($validated['quantity']);
        $unitPrice = $product->price;

        // Calculate unit price based on product type (similar to CartController)
        if ($product->size && $product->brand && $product->brand->slug !== 'toto') {
            // Parse size format: "60×90" or "60x90" to get dimensions in cm
            preg_match('/(\d+)\s*[×x]\s*(\d+)/', $product->size, $matches);
            if ($matches) {
                $width = intval($matches[1]) / 100; // Convert cm to m
                $height = intval($matches[2]) / 100;
                $tileSizeM2 = $width * $height;
                // unit_price = giá/viên = diện tích 1 viên × đơn giá/m²
                $unitPrice = intval($tileSizeM2 * $product->price);
            }
        }

        // Calculate total
        $total = $unitPrice * $quantity;

        try {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'pending',
                'delivery_address' => $validated['delivery_address'],
                'phone' => $validated['phone'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $total,
            ]);

            // Create payment
            $payment = Payment::create([
                'order_id' => $order->id,
                'transaction_id' => 'TXN-' . Str::random(12),
                'amount' => $total,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
            ]);

            $order->update(['payment_id' => $payment->id]);

            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công!',
                'redirect' => route('orders.payment', $payment->id)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi khi tạo đơn hàng. Vui lòng thử lại',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show payment page
     */
    public function payment($paymentId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $payment = Payment::findOrFail($paymentId);
        $order = $payment->order;

        // Check authorization
        if ($order->user_id !== Auth::id()) {
            return abort(403, 'Unauthorized');
        }

        $items = $order->items()->with('product')->get();

        return view('orders.payment', compact('payment', 'order', 'items'));
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request, $paymentId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $payment = Payment::findOrFail($paymentId);
        $order = $payment->order;

        // Check authorization
        if ($order->user_id !== Auth::id()) {
            return abort(403, 'Unauthorized');
        }

        // Process different payment methods
        try {
            if ($payment->payment_method === 'direct_payment') {
                // Direct payment - mark as completed immediately
                $payment->markAsCompleted();
            } elseif ($payment->payment_method === 'banking') {
                // Banking - require manual verification
                $payment->update(['status' => 'pending']);
                return redirect()->back()->with('info', 'Đơn hàng đang chờ xác nhận. Vui lòng chuyển khoản theo thông tin cung cấp');
            } elseif ($payment->payment_method === 'credit_card') {
                // Credit card - integrate with payment gateway
                return $this->processCreditCard($payment, $request);
            } elseif ($payment->payment_method === 'e_wallet') {
                // E-wallet - integrate with e-wallet provider
                return $this->processEWallet($payment, $request);
            }

            // Update order status
            $order->update(['status' => 'confirmed']);

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Thanh toán thành công!');

        } catch (\Exception $e) {
            $payment->markAsFailed();
            return redirect()->back()->with('error', 'Thanh toán thất bại. Vui lòng thử lại');
        }
    }

    /**
     * Process credit card payment
     */
    private function processCreditCard($payment, $request)
    {
        // TODO: Integrate with payment gateway (Stripe, PayPal, etc.)
        $payment->markAsCompleted();
        return redirect()->route('orders.show', $payment->order_id)
            ->with('success', 'Thanh toán bằng thẻ tín dụng thành công!');
    }

    /**
     * Process e-wallet payment
     */
    private function processEWallet($payment, $request)
    {
        // TODO: Integrate with e-wallet provider (Momo, ZaloPay, etc.)
        $payment->markAsCompleted();
        return redirect()->route('orders.show', $payment->order_id)
            ->with('success', 'Thanh toán bằng ví điện tử thành công!');
    }

    /**
     * Cancel order
     */
    public function cancel($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::findOrFail($id);

        // Check authorization
        if ($order->user_id !== Auth::id()) {
            return abort(403, 'Unauthorized');
        }

        // Can only cancel pending or confirmed orders
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng ở trạng thái này');
        }

        $order->cancel();

        return redirect()->back()->with('success', 'Đơn hàng đã được hủy');
    }
}
