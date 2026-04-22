@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-1">Dashboard</h1>
        <p class="text-gray-600">Chào mừng quay lại, {{ Auth::user()->name }}!</p>
    </div>

    <!-- KPI Cards - 4 columns -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Products -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-600 text-sm font-medium mb-2">Tổng sản phẩm</p>
                    <p class="text-4xl font-bold text-gray-900">{{ $totalProducts }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM5 16a2 2 0 11-4 0 2 2 0 014 0zm7 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Active Products -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-600 text-sm font-medium mb-2">Sản phẩm hoạt động</p>
                    <p class="text-4xl font-bold text-green-600">{{ $activeProducts }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Categories -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-600 text-sm font-medium mb-2">Danh mục</p>
                    <p class="text-4xl font-bold text-amber-600">{{ $totalCategories }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM13 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2z"></path>
                        <path d="M5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Brands -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-600 text-sm font-medium mb-2">Thương hiệu</p>
                    <p class="text-4xl font-bold text-purple-600">{{ $totalBrands }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Box -->
    @if($pendingVerifications > 0)
    <div class="mb-8 bg-gradient-to-r from-red-50 to-red-100 rounded-xl border border-red-200 p-4 flex items-center gap-4">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="font-semibold text-red-900">⚠️ Có {{ $pendingVerifications }} yêu cầu chờ xác thực</h3>
            <p class="text-sm text-red-800 mt-1">Vui lòng kiểm tra và phê duyệt các yêu cầu đăng ký nhân viên soonest.</p>
        </div>
        <a href="{{ route('admin.verifications.index') }}" class="flex-shrink-0 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors text-sm">
            Xem chi tiết
        </a>
    </div>
    @endif

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Left Column: Recent Products (2 cols) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-gray-50 to-white sticky top-0 z-10">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">📦 Sản phẩm gần đây</h2>
                        <p class="text-sm text-gray-600 mt-1">{{ $recentProducts->count() }} sản phẩm mới nhất</p>
                    </div>
                    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors text-sm whitespace-nowrap">
                        + Thêm sản phẩm
                    </a>
                </div>
                
                @if($recentProducts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tên sản phẩm</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">SKU</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Giá</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($recentProducts as $product)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm">
                                            <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $product->category->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $product->sku }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900 text-right">{{ number_format($product->price, 0, ',', '.') }} đ</td>
                                        <td class="px-6 py-4 text-center">
                                            @if($product->is_active)
                                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">✓ Hoạt động</span>
                                            @else
                                                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">○ Tắt</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="font-medium mb-2">Chưa có sản phẩm nào</p>
                        <a href="{{ route('admin.products.create') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Tạo sản phẩm đầu tiên</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Quick Actions + User Info (1 col) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Quick Actions Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">⚡ Thao tác nhanh</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.products.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition-colors group">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Thêm sản phẩm</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-amber-50 transition-colors group">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200">
                            <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Danh mục</span>
                    </a>
                    <a href="{{ route('admin.verifications.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-50 transition-colors group">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.707 6.707a1 1 0 010 1.414L5.414 9l1.293 1.293a1 1 0 01-1.414 1.414L4 10.414l-1.293 1.293a1 1 0 11-1.414-1.414L2.586 9l-1.293-1.293a1 1 0 011.414-1.414L4 7.586l1.293-1.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Xác thực</span>
                    </a>
                    <a href="{{ route('auth.change-password') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 transition-colors group">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Đổi mật khẩu</span>
                    </a>
                </div>
            </div>

            <!-- User Profile Card -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200 p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-600 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <hr class="border-blue-200 mb-4">
                <p class="text-xs text-gray-700 leading-relaxed mb-4">
                    Quản trị viên hệ thống. Bạn có quyền truy cập đầy đủ vào tất cả các tính năng.
                </p>
                <a href="{{ route('profile.edit') }}" class="w-full block text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors text-sm">
                    Cập nhật hồ sơ
                </a>
            </div>
        </div>
    </div>

    <!-- Pending Verifications Section - Full Width if exists -->
    @if($pendingVerifications > 0 && $recentVerifications->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-lg font-bold text-gray-900">🔔 Yêu cầu xác thực chờ phê duyệt</h2>
            <p class="text-sm text-gray-600 mt-1">{{ $recentVerifications->count() }} yêu cầu</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tên đăng nhập</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Vai trò</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Yêu cầu lúc</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Hết hạn</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentVerifications as $verification)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $verification->username }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $verification->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if (str_ends_with($verification->username, '.admin'))
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">👤 Admin</span>
                                @else
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">👥 Staff</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $verification->created_at->format('H:i - d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if ($verification->isExpired())
                                    <span class="text-red-600 font-semibold">❌ Đã hết</span>
                                @else
                                    <span class="text-green-600 font-semibold">⏰ {{ $verification->expires_at->format('H:i') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.verifications.show', $verification) }}" class="text-blue-600 hover:text-blue-900 font-semibold text-sm">Xem →</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
