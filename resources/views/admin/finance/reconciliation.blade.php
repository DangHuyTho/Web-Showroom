@extends('admin.layouts.app')

@section('title', 'Đối Soát Thanh Toán')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Đối Soát Thanh Toán COD</h1>
            <p class="text-gray-600 mt-2">Quản lý và đối soát các đơn hàng thanh toán trực tiếp</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">TỔNG DOANH THU ĐỐI SOÁT</h3>
            <p class="text-3xl font-bold text-green-600">
                {{ number_format($totalCOD, 0, ',', '.') }} ₫
            </p>
            <p class="text-gray-500 text-xs mt-2">Đã xác nhận thanh toán</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">CHỜ ĐỐI SOÁT</h3>
            <p class="text-3xl font-bold text-yellow-600">
                {{ number_format($pendingCOD, 0, ',', '.') }} ₫
            </p>
            <p class="text-gray-500 text-xs mt-2">Chưa xác nhận</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">TỔNG CỘNG</h3>
            <p class="text-3xl font-bold text-blue-600">
                {{ number_format($totalCOD + $pendingCOD, 0, ',', '.') }} ₫
            </p>
            <p class="text-gray-500 text-xs mt-2">Toàn bộ doanh thu</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Trạng Thái Đối Soát</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Chờ Đối Soát</option>
                    <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Đã Đối Soát</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Lọc
                </button>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-lg font-semibold">Danh sách Đơn hàng</h2>
        </div>

        @if ($orders->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Mã Đơn Hàng</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Khách Hàng</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Tổng Tiền</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Phương Thức TT</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Trạng Thái</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Ngày Giao</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold text-gray-900">#{{ $order->id }}</td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        {{ number_format($order->total_amount, 0, ',', '.') }} ₫
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @php
                            $paymentMethod = $order->payment->payment_method ?? 'N/A';
                            $paymentStatus = $order->payment->status ?? 'pending';
                            $methodLabel = [
                                'credit_card' => 'Thẻ Tín Dụng',
                                'direct_payment' => 'Thanh Toán Trực Tiếp (COD)',
                                'bank_transfer' => 'Chuyển Khoản',
                                'wallet' => 'Ví Điện Tử',
                            ][$paymentMethod] ?? $paymentMethod;
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                            {{ $methodLabel }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php $isCompleted = $paymentStatus === 'completed'; @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $isCompleted ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $isCompleted ? 'Đã Thanh Toán' : 'Chờ Thanh Toán' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $order->delivered_at ? $order->delivered_at->format('d/m/Y H:i') : '—' }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:underline">
                            Xem Chi Tiết
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $orders->render() }}
        </div>
        @else
        <div class="px-6 py-12 text-center text-gray-500">
            <p>Không tìm thấy đơn hàng nào</p>
        </div>
        @endif
    </div>

    <!-- Export Section -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Xuất Báo Cáo</h3>
        <div class="flex gap-3">
            <button onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                📄 In Báo Cáo
            </button>
            <button onclick="alert('Tính năng xuất Excel sẽ sớm được cập nhật')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                📊 Xuất Excel
            </button>
        </div>
    </div>
</div>
@endsection
