<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Show staff dashboard
     */
    public function index()
    {
        // Order Statistics
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $packedOrders = Order::where('status', 'packed')->count(); // Chờ lấy hàng
        $totalOrders = Order::count();

        // Inventory Statistics
        $lowStockCount = Product::whereRaw('quantity > 0 AND quantity <= min_stock')->count();
        $outOfStockCount = Product::where('quantity', 0)->count();
        $totalProducts = Product::count();
        $totalInventoryValue = Product::selectRaw('SUM(quantity * price) as total')->first()->total ?? 0;

        // Get recent orders
        $recentOrders = Order::latest()
            ->with('user')
            ->limit(10)
            ->get();

        // Get low stock products (exclude out of stock)
        $lowStockProducts = Product::with('brand')
            ->whereRaw('quantity > 0 AND quantity <= min_stock')
            ->orderBy('quantity', 'asc')
            ->limit(5)
            ->get();

        return view('staff.dashboard', compact(
            'pendingOrders',
            'confirmedOrders',
            'processingOrders',
            'packedOrders',
            'totalOrders',
            'lowStockCount',
            'outOfStockCount',
            'totalProducts',
            'totalInventoryValue',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}
