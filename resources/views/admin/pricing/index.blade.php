@extends('admin.layouts.app')

@section('title', 'Giá và Khuyến mãi')

@section('content')
<div class="container-fluid">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Quản lý Giá Cả & Khuyến mãi</h1>
            <p class="text-gray-600 mt-2">Chỉnh sửa giá bán, thiết lập khuyến mãi cho sản phẩm</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tên sản phẩm, SKU"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Lọc
                </button>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Sản phẩm</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Giá gốc</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Giá khuyến mãi</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Tiết kiệm</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $product->name }}</div>
                        <div class="text-sm text-gray-500">{{ $product->sku }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-semibold">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($product->sale_price)
                        <span class="text-red-600 font-semibold">{{ number_format($product->sale_price, 0, ',', '.') }} ₫</span>
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($product->sale_price)
                        <span class="text-green-600">
                            {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                        </span>
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.pricing.edit', $product->id) }}" class="text-blue-600 hover:underline">
                            Chỉnh sửa
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Không có sản phẩm nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
