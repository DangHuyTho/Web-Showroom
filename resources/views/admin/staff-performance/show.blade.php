@extends('admin.layouts.app')

@section('title', 'Chi Tiết Hiệu Suất - ' . $staff->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">{{ $staff->name }}</h1>
            <p class="text-gray-600 mt-2">@{{ $staff->username }} • {{ $staff->email }}</p>
        </div>
        <a href="{{ route('admin.staff-performance.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
            ← Quay lại
        </a>
    </div>

    <!-- KPI Cards for This Staff -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">ĐƠN HÀNG XỬ LÝ</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $ordersProcessed }}</p>
            <p class="text-gray-500 text-xs mt-2">Từ {{ $startDate }} đến {{ $endDate }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">ĐƠN HÀNG ĐÓNG GÓI</h3>
            <p class="text-3xl font-bold text-green-600">{{ $packedOrders }}</p>
            <p class="text-gray-500 text-xs mt-2">Số lượng đã vận chuyển</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">HÀNG HƯ/MẤT</h3>
            <p class="text-3xl font-bold text-red-600">
                @php
                    $totalDamages = $damages->sum('quantity_changed');
                @endphp
                {{ abs($totalDamages) }}
            </p>
            <p class="text-gray-500 text-xs mt-2">Sản phẩm bị hư hoặc mất</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">ĐIỀU CHỈNH KHO</h3>
            <p class="text-3xl font-bold text-purple-600">
                @php
                    $totalAdjustments = $adjustments->sum('count');
                @endphp
                {{ $totalAdjustments }}
            </p>
            <p class="text-gray-500 text-xs mt-2">Lần điều chỉnh kho hàng</p>
        </div>
    </div>

    <!-- Adjustment Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Chi tiết Điều chỉnh Kho</h2>
            @if ($adjustments->isNotEmpty())
            <div class="space-y-3">
                @foreach ($adjustments as $adj)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">
                            {{ ucfirst(str_replace('_', ' ', $adj->action_type)) }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $adj->count }} lần
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                        {{ $adj->qty }} sản phẩm
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-sm">Không có điều chỉnh kho trong giai đoạn này</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Chi tiết Hàng Hư/Mất</h2>
            @if ($damages->isNotEmpty())
            <div class="space-y-3">
                @foreach ($damages->groupBy('action_type') as $type => $items)
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="font-medium text-gray-900 mb-2">
                        {{ ucfirst(str_replace('_', ' ', $type)) }} ({{ $items->count() }} sản phẩm)
                    </p>
                    @foreach ($items as $damage)
                    <div class="text-sm text-gray-600">
                        • {{ $damage->product->name ?? 'N/A' }} - {{ abs($damage->quantity_changed) }} sản phẩm
                        <br><span class="text-xs text-gray-400">{{ $damage->notes ?? 'Không có ghi chú' }}</span>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-sm">Không có hàng bị hư/mất trong giai đoạn này</p>
            @endif
        </div>
    </div>

    <!-- Recent Activity Log -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4">Lịch sử Hoạt động Gần đây</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Ngày giờ</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Hành động</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Sản phẩm</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Số lượng</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentActivity as $activity)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm">{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $activity->action_type === 'sale' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $activity->action_type === 'damage' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $activity->action_type === 'loss' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ in_array($activity->action_type, ['adjustment', 'stock_in']) ? 'bg-blue-100 text-blue-800' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $activity->action_type)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $activity->product->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-sm font-medium">
                            <span class="{{ $activity->quantity_changed > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $activity->quantity_changed > 0 ? '+' : '' }}{{ $activity->quantity_changed }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $activity->notes ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            Không có hoạt động ghi nhận
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
