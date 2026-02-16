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
            
            <nav class="mt-8 px-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 mb-2 text-gray-700 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 text-gray-900 font-semibold' : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h6v6H4a1 1 0 01-1-1v-4zm8 0a1 1 0 011-1h2v6h-2a1 1 0 01-1-1v-4z" clip-rule="evenodd"></path>
                    </svg>
                    Dashboard
                </a>
                
                <div class="mt-6">
                    <h3 class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Quản lý</h3>
                    
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2 mb-2 text-gray-700 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-gray-200 text-gray-900 font-semibold' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM13 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2z"></path>
                            <path d="M5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5z"></path>
                        </svg>
                        Danh mục
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 mb-2 text-gray-700 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-gray-200 text-gray-900 font-semibold' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM5 16a2 2 0 11-4 0 2 2 0 014 0zm7 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Sản phẩm
                    </a>
                </div>
            </nav>
            
            <div class="absolute bottom-0 w-64 px-4 py-4 border-t border-gray-200">
                <a href="/" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 mb-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    Về trang chủ
                </a>
                <a href="https://github.com" target="_blank" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100" title="Admin Guide">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1h2v2H7V4zm2 4H7v2h2V8zm2-4h2v2h-2V4zm2 4h-2v2h2V8z" clip-rule="evenodd"></path>
                    </svg>
                    Hướng dẫn
                </a>
            </div>
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
