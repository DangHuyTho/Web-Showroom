@extends('admin.layouts.app')

@section('title', 'Quản lý sản phẩm')
@section('page-title', 'Quản lý sản phẩm')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-end gap-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex-1 flex gap-2 flex-wrap">
            <input type="text" name="search" placeholder="Tìm kiếm theo tên hoặc SKU..." value="{{ request('search') }}" class="flex-1 min-w-40 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            
            <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                <option value="">-- Tất cả danh mục --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            
            <select name="brand" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                <option value="">-- Tất cả thương hiệu --</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
            
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Tìm kiếm</button>
        </form>
        <a href="{{ route('admin.products.create') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">+ Thêm sản phẩm</a>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($products->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên sản phẩm</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thương hiệu</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Giá</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nổi bật</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">
                                <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($product->short_description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $product->sku }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $product->brand->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-right font-medium text-gray-900">
                                {{ number_format($product->price, 0, ',', '.') }} đ
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <form action="{{ route('admin.products.toggleFeatured', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition {{ $product->is_featured ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                        {{ $product->is_featured ? '⭐ Nổi bật' : '☆ Đánh dấu' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <form action="{{ route('admin.products.toggleActive', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2 py-1 rounded text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->is_active ? 'Hoạt động' : 'Ẩn' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-sm text-center space-x-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900">Sửa</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa sản phẩm này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $products->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center text-gray-500">
            <p>Chưa có sản phẩm nào. <a href="{{ route('admin.products.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">Tạo sản phẩm đầu tiên</a></p>
        </div>
    @endif
</div>
@endsection
