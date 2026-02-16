@extends('admin.layouts.app')

@section('title', 'Admin - Hộ Nhâm Showroom')
@section('page-title', 'Chào mừng tới Admin Panel')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-2">Danh mục</h3>
        <p class="mb-4">Quản lý tất cả các danh mục sản phẩm trên website</p>
        <a href="{{ route('admin.categories.index') }}" class="inline-block px-4 py-2 bg-white text-blue-600 rounded font-medium hover:bg-gray-100">Quản lý →</a>
    </div>
    
    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-2">Sản phẩm</h3>
        <p class="mb-4">Quản lý các sản phẩm, giá cả và thông tin chi tiết</p>
        <a href="{{ route('admin.products.index') }}" class="inline-block px-4 py-2 bg-white text-green-600 rounded font-medium hover:bg-gray-100">Quản lý →</a>
    </div>
    
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-2">Thống kê</h3>
        <p class="mb-4">Xem tổng quan về website và các chỉ số quan trọng</p>
        <a href="{{ route('admin.dashboard') }}" class="inline-block px-4 py-2 bg-white text-purple-600 rounded font-medium hover:bg-gray-100">Xem chi tiết →</a>
    </div>
</div>
@endsection
