@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Giá')

@section('content')
<div class="container-fluid max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Chỉnh sửa Giá - {{ $product->name }}</h1>

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <h3 class="text-red-800 font-semibold mb-2">Có lỗi xảy ra:</h3>
        <ul class="text-red-700 list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.pricing.update', $product->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PATCH')

        <!-- Product Info -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-gray-600 text-sm">Sản phẩm</span>
                    <p class="font-semibold">{{ $product->name }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">SKU</span>
                    <p class="font-semibold">{{ $product->sku }}</p>
                </div>
            </div>
        </div>

        <!-- Pricing -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Giá Bán</h3>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Giá gốc *</label>
                <div class="flex items-center">
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <span class="ml-2 text-gray-600">₫</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Đây là giá bán thông thường</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Giá khuyến mãi (tùy chọn)</label>
                <div class="flex items-center">
                    <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <span class="ml-2 text-gray-600">₫</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Để trống nếu không có khuyến mãi</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ngày bắt đầu (tùy chọn)</label>
                    <input type="date" name="sale_start_date" value="{{ old('sale_start_date', $product->sale_start_date) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ngày kết thúc (tùy chọn)</label>
                    <input type="date" name="sale_end_date" value="{{ old('sale_end_date', $product->sale_end_date) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Preview -->
        @if($product->sale_price)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-blue-600">
                <strong>Tiết kiệm:</strong> {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% 
                ({{ number_format($product->price - $product->sale_price, 0, ',', '.') }} ₫)
            </p>
        </div>
        @endif

        <!-- Submit -->
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Cập nhật Giá
            </button>
            <a href="{{ route('admin.pricing.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection
