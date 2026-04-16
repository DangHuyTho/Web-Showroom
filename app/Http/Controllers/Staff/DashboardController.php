<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class DashboardController extends Controller
{
    /**
     * Show staff dashboard
     */
    public function index()
    {
        // Get statistics
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $totalOrders = Order::count();

        // Get recent orders
        $recentOrders = Order::latest()
            ->with('user')
            ->limit(10)
            ->get();

        return view('staff.dashboard', compact(
            'pendingOrders',
            'confirmedOrders',
            'processingOrders',
            'totalOrders',
            'recentOrders'
        ));
    }
}
