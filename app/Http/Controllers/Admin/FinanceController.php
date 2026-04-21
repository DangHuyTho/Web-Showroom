<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    /**
     * Show revenue dashboard
     */
    public function index(Request $request)
    {
        $period = $request->get('period', 'month'); // day, month, year
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $date = $request->get('date', now()->format('Y-m-d'));

        $query = Order::where('status', 'delivered');

        // Date filtering
        if ($period === 'day') {
            $query->whereDate('delivered_at', $date);
            $dateLabel = "Ngày " . date('d/m/Y', strtotime($date));
        } elseif ($period === 'month') {
            $query->whereYear('delivered_at', $year)
                  ->whereMonth('delivered_at', $month);
            $dateLabel = "Tháng " . str_pad($month, 2, '0', STR_PAD_LEFT) . "/" . $year;
        } else {
            $query->whereYear('delivered_at', $year);
            $dateLabel = "Năm " . $year;
        }

        // Revenue statistics
        $totalRevenue = $query->sum('total_amount');
        $totalOrders = $query->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Payment method breakdown
        $paymentMethods = Payment::whereIn('status', ['completed', 'confirmed'])
            ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method')
            ->get();

        // Daily revenue (for chart)
        if ($period === 'month') {
            $dailyRevenue = Order::where('status', 'delivered')
                ->whereYear('delivered_at', $year)
                ->whereMonth('delivered_at', $month)
                ->selectRaw('DATE(delivered_at) as date, COUNT(*) as count, SUM(total_amount) as revenue')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } elseif ($period === 'year') {
            $dailyRevenue = Order::where('status', 'delivered')
                ->whereYear('delivered_at', $year)
                ->selectRaw('DATE_TRUNC(\'month\', delivered_at) as month, COUNT(*) as count, SUM(total_amount) as revenue')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            $dailyRevenue = collect();
        }

        // Order status breakdown
        $statusBreakdown = Order::selectRaw('status, COUNT(*) as count, SUM(total_amount) as revenue')
            ->groupBy('status')
            ->get();

        // Top customers
        $topCustomers = Order::with('user')
            ->where('status', 'delivered')
            ->selectRaw('user_id, COUNT(*) as order_count, SUM(total_amount) as total_spent')
            ->groupBy('user_id')
            ->orderBy('total_spent', 'desc')
            ->take(10)
            ->get();

        return view('admin.finance.index', compact(
            'totalRevenue',
            'totalOrders',
            'averageOrderValue',
            'paymentMethods',
            'dailyRevenue',
            'statusBreakdown',
            'topCustomers',
            'period',
            'year',
            'month',
            'date',
            'dateLabel'
        ));
    }

    /**
     * Show order reconciliation (COD collections)
     */
    public function reconciliation(Request $request)
    {
        $status = $request->get('status', 'pending'); // pending, confirmed, reconciled

        $query = Order::with('user', 'payment')
            ->where('status', 'delivered');

        // Filter by reconciliation status (we can use payment.status for this)
        // This is a simplified version - in real system you'd have a separate reconciliation table
        if ($status === 'confirmed') {
            $query->whereHas('payment', function ($q) {
                $q->where('status', 'completed');
            });
        }

        $orders = $query->paginate(20);

        // Summary
        $totalCOD = Order::where('status', 'delivered')
            ->whereHas('payment', function ($q) {
                $q->where('payment_method', 'direct_payment')
                  ->where('status', 'completed');
            })
            ->sum('total_amount');

        $pendingCOD = Order::where('status', 'delivered')
            ->whereHas('payment', function ($q) {
                $q->where('payment_method', 'direct_payment')
                  ->where('status', 'pending');
            })
            ->sum('total_amount');

        return view('admin.finance.reconciliation', compact(
            'orders',
            'totalCOD',
            'pendingCOD',
            'status'
        ));
    }

    /**
     * Show expenses/costs
     */
    public function expenses(Request $request)
    {
        $period = $request->get('period', 'month');
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // This would typically come from an Expenses/Costs table
        // For now, we'll show a placeholder
        $expenses = collect([
            ['category' => 'Nhập hàng', 'amount' => 50000000],
            ['category' => 'Phí sàn thương mại', 'amount' => 5000000],
            ['category' => 'Phí vận chuyển', 'amount' => 8000000],
            ['category' => 'Chi phí nhân viên', 'amount' => 20000000],
            ['category' => 'Tiện ích (điện, nước)', 'amount' => 3000000],
        ]);

        $totalExpenses = $expenses->sum('amount');

        return view('admin.finance.expenses', compact(
            'expenses',
            'totalExpenses',
            'period',
            'year',
            'month'
        ));
    }
}
