<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\InventoryLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffPerformanceController extends Controller
{
    /**
     * Show staff KPI dashboard
     */
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Get all staff users
        $staffUsers = User::where('role', 'staff')->where('is_active', true)->get();

        // KPI 1: Order confirmation speed
        // Count orders confirmed by each staff member and their average confirmation time
        $confirmationStats = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'pending')
            ->get()
            ->groupBy(function ($order) {
                // Count who confirmed - we track via InventoryLog action='sale' (deduction happened)
                return $order->id;
            });

        // KPI 2: Packing performance
        // Count orders packed by tracking packed_at timestamp
        $packingStats = Order::whereBetween('packed_at', [$startDate, $endDate])
            ->whereNotNull('packed_at')
            ->count();

        // KPI 3: Inventory losses
        // Track damage and loss records from InventoryLog
        $damageStats = InventoryLog::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('action_type', ['damage', 'loss'])
            ->select('user_id', 'action_type', DB::raw('SUM(ABS(quantity_changed)) as total_quantity'))
            ->groupBy('user_id', 'action_type')
            ->get();

        // KPI 4: Confirmation time analysis
        // Orders confirmed per day
        $ordersConfirmedPerDay = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'pending')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get();

        // Staff activity - stock adjustments made
        $staffActivity = InventoryLog::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('action_type', ['adjustment', 'stock_in'])
            ->select('user_id', DB::raw('COUNT(*) as adjustments'), DB::raw('SUM(ABS(quantity_changed)) as total_qty'))
            ->groupBy('user_id')
            ->get();

        return view('admin.staff-performance.index', compact(
            'staffUsers',
            'packingStats',
            'damageStats',
            'ordersConfirmedPerDay',
            'staffActivity',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Show individual staff member detail
     */
    public function show($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);
        
        $startDate = request()->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = request()->get('end_date', now()->format('Y-m-d'));

        // Orders processed by this staff member
        $ordersProcessed = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'pending')
            ->count();

        // Packed orders
        $packedOrders = Order::whereBetween('packed_at', [$startDate, $endDate])
            ->whereNotNull('packed_at')
            ->count();

        // Inventory adjustments
        $adjustments = InventoryLog::whereBetween('created_at', [$startDate, $endDate])
            ->where('user_id', $id)
            ->select('action_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(ABS(quantity_changed)) as qty'))
            ->groupBy('action_type')
            ->get();

        // Damage/loss items
        $damages = InventoryLog::whereBetween('created_at', [$startDate, $endDate])
            ->where('user_id', $id)
            ->whereIn('action_type', ['damage', 'loss'])
            ->get();

        // Recent activity
        $recentActivity = InventoryLog::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return view('admin.staff-performance.show', compact(
            'staff',
            'ordersProcessed',
            'packedOrders',
            'adjustments',
            'damages',
            'recentActivity',
            'startDate',
            'endDate'
        ));
    }
}
