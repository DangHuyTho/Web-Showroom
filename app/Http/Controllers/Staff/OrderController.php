<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

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

        // Search by order ID or user name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
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

        return view('staff.orders.show', compact('order', 'items'));
    }

    /**
     * Confirm order
     */
    public function confirm(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Đơn hàng không ở trạng thái chờ xác nhận');
        }

        $order->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận');
    }

    /**
     * Start processing order
     */
    public function process(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Chỉ có thể xử lý đơn hàng đã xác nhận');
        }

        $order->update(['status' => 'processing']);

        return redirect()->back()->with('success', 'Đơn hàng đã được bắt đầu xử lý');
    }

    /**
     * Mark order as shipped
     */
    public function ship(Request $request, $id)
    {
        $validated = $request->validate([
            'tracking_number' => 'nullable|string',
        ]);

        $order = Order::findOrFail($id);

        if ($order->status !== 'processing') {
            return redirect()->back()->with('error', 'Chỉ có thể gửi hàng cho đơn đang xử lý');
        }

        $order->update(['status' => 'shipped']);

        return redirect()->back()->with('success', 'Đơn hàng đã được gửi đi');
    }

    /**
     * Mark order as delivered
     */
    public function deliver(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'shipped') {
            return redirect()->back()->with('error', 'Chỉ có thể hoàn thành đơn đã gửi đi');
        }

        $order->update(['status' => 'delivered']);

        return redirect()->back()->with('success', 'Đơn hàng đã hoàn thành');
    }

    /**
     * Reject/cancel order
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string',
        ]);

        $order = Order::findOrFail($id);

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng ở trạng thái này');
        }

        $order->update([
            'status' => 'cancelled',
            'notes' => ($order->notes ?? '') . "\n[Từ chối nhân viên: {$validated['reason']}]",
        ]);

        return redirect()->back()->with('success', 'Đơn hàng đã bị từ chối');
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
