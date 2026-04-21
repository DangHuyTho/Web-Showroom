<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\InventoryLog;
use App\Mail\OrderConfirmedMail;
use App\Mail\OrderShippedMail;
use App\Mail\OrderDeliveredMail;

class OrderController extends Controller
{
    /**
     * Show all orders for staff management
     */
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by order ID, customer name, or phone
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($user) use ($search) {
                      $user->where('name', 'like', "%{$search}%")
                           ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(15);

        return view('staff.orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items', 'payment'])->findOrFail($id);
        $items = $order->items()->with('product')->get();
        $inventoryLogs = InventoryLog::where('reference_id', $order->id)
            ->with(['product', 'user'])
            ->latest()
            ->get();

        return view('staff.orders.show', compact('order', 'items', 'inventoryLogs'));
    }

    /**
     * Confirm order with stock validation
     */
    public function confirm(Request $request, $id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Đơn hàng không ở trạng thái chờ xác nhận');
        }

        // Check stock availability
        if (!$order->hasEnoughStock()) {
            $outOfStock = $order->getOutOfStockItems();
            $message = 'Không đủ tồn kho cho sản phẩm: ' . 
                implode(', ', array_map(fn($item) => "{$item['product']} (cần: {$item['needed']}, có: {$item['available']})", $outOfStock));
            
            return redirect()->back()->with('error', $message);
        }

        // Deduct stock
        $order->deductStock();

        // Update order status
        $order->update([
            'status' => 'confirmed'
        ]);

        // Send email to customer
        Mail::to($order->user->email)->queue(new OrderConfirmedMail($order));

        return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận và tồn kho đã được trừ');
    }

    /**
     * Start processing order (bắt đầu chuẩn bị hàng)
     */
    public function process(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Chỉ có thể xử lý đơn hàng đã xác nhận');
        }

        $order->update(['status' => 'processing']);

        return redirect()->back()->with('success', 'Bắt đầu chuẩn bị hàng cho đơn hàng');
    }

    /**
     * Print packing slip / vận đơn
     */
    public function printPackingSlip($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        if (!in_array($order->status, ['confirmed', 'processing'])) {
            return redirect()->back()->with('error', 'Chỉ có thể in vận đơn cho đơn hàng đã xác nhận hoặc đang xử lý');
        }

        return view('staff.orders.packing-slip', compact('order'));
    }

    /**
     * Mark order as packed (đã đóng gói)
     */
    public function pack(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'processing') {
            return redirect()->back()->with('error', 'Chỉ có thể đóng gói đơn đang xử lý');
        }

        $order->update([
            'status' => 'packed',
            'packed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Đơn hàng đã được đóng gói. Chờ shipper lấy hàng');
    }

    /**
     * Handover order to shipper (bàn giao vận chuyển)
     */
    public function handover(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'packed') {
            return redirect()->back()->with('error', 'Chỉ có thể bàn giao đơn đã đóng gói');
        }

        $order->update([
            'status' => 'shipped',
            'shipped_at' => now(),
        ]);

        // Send email to customer
        Mail::to($order->user->email)->queue(new OrderShippedMail($order));

        return redirect()->back()->with('success', 'Đơn hàng đã được bàn giao cho đơn vị vận chuyển');
    }

    /**
     * Mark order as delivered (đã giao khách)
     */
    public function deliver(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'shipped') {
            return redirect()->back()->with('error', 'Chỉ có thể hoàn thành đơn đã gửi đi');
        }

        $order->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        // Send email to customer
        Mail::to($order->user->email)->queue(new OrderDeliveredMail($order));

        return redirect()->back()->with('success', 'Đơn hàng đã hoàn thành');
    }

    /**
     * Cancel/reject order
     */
    public function cancel(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $order = Order::findOrFail($id);

        // Can only cancel pending or confirmed orders
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng ở trạng thái này');
        }

        // Restore stock if already confirmed
        if ($order->status === 'confirmed') {
            $order->restoreStock();
        }

        $order->update([
            'status' => 'cancelled',
            'notes' => ($order->notes ?? '') . "\n[Hủy bởi nhân viên: {$validated['reason']}]",
        ]);

        return redirect()->back()->with('success', 'Đơn hàng đã bị hủy');
    }

    /**
     * Get inventory report (for stock management)
     */
    public function inventory()
    {
        // Get products with sales count
        $products = \App\Models\Product::withCount([
            'orderItems',
            'orderItems as sold_quantity' => function ($query) {
                $query->select(\DB::raw('COALESCE(SUM(quantity), 0)'));
            }
        ])->paginate(15);

        return view('staff.inventory.index', compact('products'));
    }

    /**
     * Export inventory report
     */
    public function exportInventory()
    {
        $products = \App\Models\Product::with('orderItems')
            ->get();

        $csvData = "Tên sản phẩm,SKU,Giá,Số lượng bán\n";
        
        foreach ($products as $product) {
            $soldQty = $product->orderItems()->sum('quantity');
            $csvData .= "\"{$product->name}\",\"{$product->sku}\",{$product->price},{$soldQty}\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=inventory-' . date('Y-m-d') . '.csv');
    }
}

