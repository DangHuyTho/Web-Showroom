@extends('admin.layouts.app')

@section('title', 'Quản Lý Chi Phí')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Quản Lý Chi Phí & Doanh Thu</h1>
            <p class="text-gray-600 mt-2">Theo dõi các chi phí hoạt động kinh doanh</p>
        </div>
    </div>

    <!-- Period Filter -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Chu Kỳ</label>
                <select name="period" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Theo Tháng</option>
                    <option value="quarter" {{ $period === 'quarter' ? 'selected' : '' }}>Theo Quý</option>
                    <option value="year" {{ $period === 'year' ? 'selected' : '' }}>Theo Năm</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Năm</label>
                <select name="year" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @for ($y = now()->year - 5; $y <= now()->year; $y++)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tháng</label>
                <select name="month" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" {{ $period !== 'month' ? 'disabled' : '' }}>
                    @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Lọc
                </button>
            </div>

            <div class="flex items-end">
                <a href="{{ route('admin.finance.expenses') }}" class="w-full bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 text-center">
                    Đặt lại
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">TỔNG CHI PHÍ</h3>
            <p class="text-3xl font-bold text-red-600">
                {{ number_format($totalExpenses, 0, ',', '.') }} ₫
            </p>
            <p class="text-gray-500 text-xs mt-2">Tháng {{ $month }}/{{ $year }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">HẠNG MỤC CHI PHÍ</h3>
            <p class="text-3xl font-bold text-purple-600">{{ count($expenses) }}</p>
            <p class="text-gray-500 text-xs mt-2">Số hạng mục</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
            <h3 class="text-gray-600 text-sm font-semibold mb-2">CHI PHÍ TRUNG BÌNH</h3>
            <p class="text-3xl font-bold text-orange-600">
                {{ count($expenses) > 0 ? number_format($totalExpenses / count($expenses), 0, ',', '.') : 0 }} ₫
            </p>
            <p class="text-gray-500 text-xs mt-2">Mỗi hạng mục</p>
        </div>
    </div>

    <!-- Expenses Detail -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-lg font-semibold">Chi tiết Chi Phí</h2>
        </div>

        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Hạng Mục</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold">Số Tiền</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">% Tổng Chi Phí</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Biểu Đồ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($expenses as $expense)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $expense['category'] }}
                    </td>
                    <td class="px-6 py-4 text-right font-semibold text-gray-900">
                        {{ number_format($expense['amount'], 0, ',', '.') }} ₫
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $percentage = $totalExpenses > 0 ? ($expense['amount'] / $totalExpenses) * 100 : 0;
                        @endphp
                        <span class="px-2 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                            {{ number_format($percentage, 1) }}%
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 w-full max-w-xs">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-sm font-medium whitespace-nowrap">{{ number_format($percentage, 1) }}%</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                        Không có dữ liệu chi phí
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                <tr>
                    <td class="px-6 py-3 font-semibold text-gray-900">TỔNG CỘNG</td>
                    <td class="px-6 py-3 text-right font-bold text-gray-900">
                        {{ number_format($totalExpenses, 0, ',', '.') }} ₫
                    </td>
                    <td colspan="2" class="px-6 py-3 text-right font-semibold text-gray-600">
                        100%
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Expense Breakdown by Category -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Category List -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Chi Tiết Từng Hạng Mục</h3>
            <div class="space-y-3">
                @foreach ($expenses as $expense)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">{{ $expense['category'] }}</p>
                        @php
                            $pct = $totalExpenses > 0 ? ($expense['amount'] / $totalExpenses) * 100 : 0;
                        @endphp
                        <p class="text-sm text-gray-500">{{ number_format($pct, 1) }}% tổng chi phí</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 whitespace-nowrap">
                        {{ number_format($expense['amount'], 0, ',', '.') }} ₫
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Monthly Projection -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Dự Báo & Phân Tích</h3>
            <div class="space-y-4">
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-gray-600 mb-1">Chi phí hàng tháng trung bình</p>
                    <p class="text-2xl font-bold text-blue-600">
                        {{ number_format($totalExpenses, 0, ',', '.') }} ₫
                    </p>
                </div>

                <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                    <p class="text-sm text-gray-600 mb-1">Tổng chi phí trong năm (dự kiến)</p>
                    <p class="text-2xl font-bold text-green-600">
                        {{ number_format($totalExpenses * 12, 0, ',', '.') }} ₫
                    </p>
                </div>

                <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
                    <p class="text-sm text-gray-600 mb-1">Chi phí hàng ngày trung bình</p>
                    <p class="text-2xl font-bold text-purple-600">
                        {{ number_format($totalExpenses / 30, 0, ',', '.') }} ₫
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Xuất Báo Cáo</h3>
        <div class="flex gap-3">
            <button onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                📄 In Báo Cáo
            </button>
            <a href="{{ route('admin.finance.expenses.export', ['period' => request('period', 'month'), 'year' => request('year', now()->year), 'month' => request('month', now()->month)]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-block">
                📊 Xuất Excel
            </a>
        </div>
    </div>
</div>

<script>
    // Enable/disable month select based on period
    document.querySelector('select[name="period"]').addEventListener('change', function() {
        document.querySelector('select[name="month"]').disabled = this.value !== 'month';
    });
</script>
@endsection
