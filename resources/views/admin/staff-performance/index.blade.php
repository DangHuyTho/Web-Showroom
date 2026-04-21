@extends('admin.layouts.app')

@section('title', 'Hiệu Suất Nhân Viên')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Hiệu Suất Nhân Viên</h1>
            <p class="text-gray-600 mt-2">Theo dõi KPI và hiệu suất làm việc của nhân viên kho</p>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Từ ngày</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Đến ngày</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Lọc
                </button>
            </div>
            <div class="flex items-end">
                <a href="{{ route('admin.staff-performance.index') }}" class="w-full bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 text-center">
                    Đặt lại
                </a>
            </div>
        </form>
    </div>

    <!-- KPI Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">ĐƠNHÀNG ĐÃ XỬ LÝ</h3>
            <p class="text-3xl font-bold text-blue-600">
                @php
                    $totalOrders = $ordersConfirmedPerDay->sum('count');
                @endphp
                {{ $totalOrders }}
            </p>
            <p class="text-gray-500 text-xs mt-2">Trong giai đoạn {{ $startDate }} đến {{ $endDate }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">ĐƠNHÀNG ĐÃ ĐÓNG GÓI</h3>
            <p class="text-3xl font-bold text-green-600">{{ $packingStats }}</p>
            <p class="text-gray-500 text-xs mt-2">Số lượng đã vận chuyển</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">HÀNG HỎNGTổn HỤ/MẤT</h3>
            <p class="text-3xl font-bold text-red-600">
                @php
                    $totalDamage = $damageStats->sum('total_quantity');
                @endphp
                {{ $totalDamage }}
            </p>
            <p class="text-gray-500 text-xs mt-2">Sản phẩm hư/mất trong kỳ</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">NHÂN VIÊN HOẠT ĐỘNG</h3>
            <p class="text-3xl font-bold text-purple-600">{{ count($staffUsers) }}</p>
            <p class="text-gray-500 text-xs mt-2">Nhân viên kho đang hoạt động</p>
        </div>
    </div>

    <!-- Staff Performance Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-lg font-semibold">Chi tiết Hiệu suất Nhân viên</h2>
        </div>
        
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Tên Nhân Viên</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Đơn hàng Xử lý</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Đơn hàng Đóng gói</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Hàng Hư/Mất</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Điều chỉnh Kho</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($staffUsers as $staff)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $staff->name }}</p>
                            <p class="text-sm text-gray-500">@{{ $staff->username }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $staffOrderCount = $ordersConfirmedPerDay->sum('count');
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                            {{ $staffOrderCount }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            {{ $packingStats }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $staffDamage = $damageStats->where('user_id', $staff->id)->sum('total_quantity');
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm font-semibold 
                            {{ $staffDamage > 0 ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $staffDamage }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $staffAdj = $staffActivity->where('user_id', $staff->id)->first();
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                            {{ $staffAdj ? $staffAdj->adjustments : 0 }} ({{ $staffAdj ? $staffAdj->total_qty : 0 }} sản phẩm)
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('admin.staff-performance.show', $staff->id) }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
                            class="text-blue-600 hover:underline">
                            Xem chi tiết
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Chưa có nhân viên hoạt động
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Daily Order Statistics -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Đơn hàng Xử lý Hàng ngày</h3>
            <div class="space-y-2">
                @foreach ($ordersConfirmedPerDay as $stat)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($stat->date)->format('d/m/Y') }}</span>
                    <div class="flex items-center gap-2">
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min($stat->count * 10, 100) }}%"></div>
                        </div>
                        <span class="font-semibold text-blue-600 w-8 text-right">{{ $stat->count }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Thống kê Hữu hại</h3>
            <div class="space-y-3">
                @if ($damageStats->isNotEmpty())
                    @foreach ($damageStats as $stat)
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $stat->user_id ? \App\Models\User::find($stat->user_id)->name ?? 'N/A' : 'Không xác định' }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ ucfirst(str_replace('_', ' ', $stat->action_type)) }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                            {{ $stat->total_quantity }} sản phẩm
                        </span>
                    </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-sm">Không có hàng bị hư/mất trong giai đoạn này</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
