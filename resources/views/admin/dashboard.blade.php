@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Products -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-1">
                <p class="text-gray-500 text-sm font-medium">Tổng sản phẩm</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalProducts }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM5 16a2 2 0 11-4 0 2 2 0 014 0zm7 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Active Products -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-1">
                <p class="text-gray-500 text-sm font-medium">Sản phẩm hoạt động</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeProducts }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Total Categories -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-1">
                <p class="text-gray-500 text-sm font-medium">Danh mục</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalCategories }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM13 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2z"></path>
                    <path d="M5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Total Brands -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-1">
                <p class="text-gray-500 text-sm font-medium">Thương hiệu</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalBrands }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Account Management Card -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-2">⚙️ Quản lý tài khoản</h2>
            <p class="text-sm text-gray-600 mb-4">Cập nhật mật khẩu và quản lý cài đặt tài khoản của bạn</p>
            <a href="{{ route('auth.change-password') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                Đổi Mật Khẩu →
            </a>
        </div>
    </div>
</div>

<!-- Recent Products -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">Sản phẩm gần đây</h2>
        <a href="{{ route('admin.products.create') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Thêm mới →</a>
    </div>
    
    @if($recentProducts->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên sản phẩm</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Giá</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentProducts as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="font-medium">{{ $product->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $product->sku }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ number_format($product->price, 0, ',', '.') }} đ</td>
                            <td class="px-6 py-4 text-sm">
                                @if($product->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Hoạt động</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">Không hoạt động</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 mr-3">Sửa</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-900">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="px-6 py-8 text-center text-gray-500">
            <p>Chưa có sản phẩm nào. <a href="{{ route('admin.products.create') }}" class="text-blue-600 hover:text-blue-700">Tạo sản phẩm đầu tiên</a></p>
        </div>
    @endif
</div>
@endsection
