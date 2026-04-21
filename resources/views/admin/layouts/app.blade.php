<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Hộ Nhâm')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <style>
        :root {
            --color-primary: #1a1a1a;
            --color-secondary: #d4af37;
            --color-accent: #f5f5f0;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="flex items-center justify-center h-16 bg-gray-900 text-white">
                <span class="text-xl font-bold">Admin Panel</span>
            </div>
            
            <nav class="mt-6 px-2 pb-20 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h6v6H4a1 1 0 01-1-1v-4zm8 0a1 1 0 011-1h2v6h-2a1 1 0 01-1-1v-4z" clip-rule="evenodd"></path>
                    </svg>
                    Dashboard
                </a>
                
                <div class="mt-6">
                    <h3 class="px-3 py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide">Quản lý</h3>
                    
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.5 1.5H5.75A2.25 2.25 0 003.5 3.75v12.5A2.25 2.25 0 005.75 18.5h8.5a2.25 2.25 0 002.25-2.25V9"></path>
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM6.5 11a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"></path>
                        </svg>
                        Quản lý Tài Khoản
                    </a>

                    <a href="{{ route('admin.verifications.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.verifications.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Xác thực tài khoản
                    </a>
                    
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM13 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2z"></path>
                            <path d="M5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5z"></path>
                        </svg>
                        Danh mục
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM5 16a2 2 0 11-4 0 2 2 0 014 0zm7 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Sản phẩm
                    </a>

                    <a href="{{ route('admin.staff-performance.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.staff-performance.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h.01a1 1 0 110 2H12zm-2 2a1 1 0 100-2 1 1 0 000 2zm-4 2a1 1 0 110-2h.01a1 1 0 110 2H6z" clip-rule="evenodd"></path>
                        </svg>
                        Hiệu suất Staff
                    </a>

                    <a href="{{ route('admin.inspiration-posts.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.inspiration-posts.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a2 2 0 01-2-2V4zm3 1h6v2H7V5zm0 4h6v2H7V9z"></path>
                        </svg>
                        Nội Dung
                    </a>
                </div>

                <div class="mt-5">
                    <h3 class="px-3 py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide">Giá & Khuyến Mãi</h3>

                    <a href="{{ route('admin.pricing.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.pricing.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.16 5.314l4.897-1.596A1 1 0 0114.59 4.79l1.293 5.413a1 1 0 01-.757 1.222l-4.897 1.596a1 1 0 01-1.222-.757L5.4 6.536a1 1 0 01.757-1.222zM5 12.5a.5.5 0 11-1 0 .5.5 0 011 0zm6 0a.5.5 0 11-1 0 .5.5 0 011 0z"></path>
                        </svg>
                        Giá & Khuyến Mãi
                    </a>
                </div>

                <div class="mt-5">
                    <h3 class="px-3 py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide">Tài Chính</h3>

                    <a href="{{ route('admin.finance.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.finance.index') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        Doanh Thu
                    </a>

                    <a href="{{ route('admin.finance.reconciliation') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.finance.reconciliation') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zm6-7a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zm6-3a1 1 0 011-1h2a1 1 0 011 1v15a1 1 0 01-1 1h-2a1 1 0 01-1-1V1z" clip-rule="evenodd"></path>
                        </svg>
                        Đối Soát
                    </a>

                    <a href="{{ route('admin.finance.expenses') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.finance.expenses') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                        </svg>
                        Chi Phí
                    </a>

                    <a href="{{ route('admin.settings.payment') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.settings.payment') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                        Thanh Toán
                    </a>
                </div>

                <div class="mt-5">
                    <h3 class="px-3 py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide">Cấu Hình</h3>

                    <a href="{{ route('admin.settings.general') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.settings.general') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                        Cài Đặt Chung
                    </a>

                    <a href="{{ route('admin.settings.shipping') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg {{ request()->routeIs('admin.settings.shipping') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                            <path fill-rule="evenodd" d="M3 6a1 1 0 000 2h14a1 1 0 100-2H3zm0 4a1 1 0 000 2h14a1 1 0 100-2H3z" clip-rule="evenodd"></path>
                        </svg>
                        Vận Chuyển
                    </a>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Bar -->
        <div class="bg-white shadow-sm h-16 flex items-center justify-between px-8 border-b border-gray-200">
            <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
            <div class="flex items-center gap-4">
                <div class="text-sm text-gray-600">
                    {{ date('d/m/Y H:i') }}
                </div>
                <div class="flex items-center gap-3 pl-3 border-l border-gray-200">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">@{{ Auth::user()->username ?? 'admin' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                            Đăng Xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>
            
            <!-- Page Content -->
            <div class="flex-1 overflow-auto p-8">
                <!-- Notifications -->
                @if ($message = Session::get('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ $message }}
                    </div>
                @endif
                
                @if ($message = Session::get('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ $message }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <strong>Có lỗi xảy ra:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
