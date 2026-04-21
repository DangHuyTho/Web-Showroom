@extends('admin.layouts.app')

@section('title', 'Báo Cáo Tài Chính')

@section('content')
<div class="container-fluid">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Báo Cáo Tài Chính & Doanh Thu</h1>
            <p class="text-gray-600 mt-2">Thống kê doanh thu theo ngày, tháng, năm</p>
        </div>
    </div>

    <!-- Period Filter -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Khoảng thời gian</label>
                <select name="period" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="day" {{ request('period') === 'day' ? 'selected' : '' }}>Theo Ngày</option>
                    <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Theo Tháng</option>
                    <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Theo Năm</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Năm</label>
                <input type="number" name="year" value="{{ $year }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tháng</label>
                <input type="number" name="month" value="{{ $month }}" min="1" max="12" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Xem
                </button>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-gray-600 text-sm">Tổng Doanh Thu</p>
            <h3 class="text-2xl font-bold mt-2">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</h3>
            <p class="text-xs text-gray-500 mt-2">{{ $dateLabel }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-gray-600 text-sm">Tổng Đơn Hàng</p>
            <h3 class="text-2xl font-bold mt-2">{{ $totalOrders }}</h3>
            <p class="text-xs text-gray-500 mt-2">đơn hàng đã giao</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-gray-600 text-sm">Giá Trị Trung Bình</p>
            <h3 class="text-2xl font-bold mt-2">{{ number_format($averageOrderValue, 0, ',', '.') }} ₫</h3>
            <p class="text-xs text-gray-500 mt-2">trên mỗi đơn</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-gray-600 text-sm">Phương Thức Thanh Toán</p>
            <h3 class="text-2xl font-bold mt-2">{{ $paymentMethods->count() }}</h3>
            <p class="text-xs text-gray-500 mt-2">phương thức</p>
        </div>
    </div>

    <!-- Revenue by Payment Method -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Doanh Thu Theo Phương Thức Thanh Toán</h3>
            <table class="w-full text-sm">
                <thead class="border-b">
                    <tr>
                        <th class="text-left py-2">Phương thức</th>
                        <th class="text-right py-2">Số lượng</th>
                        <th class="text-right py-2">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paymentMethods as $method)
                    <tr class="border-b">
                        <td class="py-2">{{ ucfirst(str_replace('_', ' ', $method->payment_method)) }}</td>
                        <td class="text-right">{{ $method->count }}</td>
                        <td class="text-right font-semibold">{{ number_format($method->total, 0, ',', '.') }} ₫</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-500">Không có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Đơn Hàng Theo Trạng Thái</h3>
            <table class="w-full text-sm">
                <thead class="border-b">
                    <tr>
                        <th class="text-left py-2">Trạng thái</th>
                        <th class="text-right py-2">Số lượng</th>
                        <th class="text-right py-2">Giá trị</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($statusBreakdown as $status)
                    <tr class="border-b">
                        <td class="py-2">{{ ucfirst($status->status) }}</td>
                        <td class="text-right">{{ $status->count }}</td>
                        <td class="text-right font-semibold">{{ number_format($status->revenue, 0, ',', '.') }} ₫</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-500">Không có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Customers -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">10 Khách Hàng Hàng Đầu</h3>
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Khách hàng</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Số đơn</th>
                    <th class="px-4 py-3 text-right text-sm font-semibold">Tổng chi tiêu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topCustomers as $customer)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $customer->user->name }}</td>
                    <td class="px-4 py-3">{{ $customer->order_count }}</td>
                    <td class="px-4 py-3 text-right font-semibold">{{ number_format($customer->total_spent, 0, ',', '.') }} ₫</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-3 text-center text-gray-500">Không có dữ liệu</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
