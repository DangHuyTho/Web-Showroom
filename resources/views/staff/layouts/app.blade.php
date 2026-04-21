<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Staff - Hộ Nhâm')</title>
    
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
            --color-success: #10b981;
            --color-warning: #f59e0b;
            --color-danger: #ef4444;
            --color-info: #3b82f6;
            --spacing-xs: 0.25rem;
            --spacing-md: 0.5rem;
            --spacing-lg: 1rem;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-align: center;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #b45309;
        }

        .badge-confirmed {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-processing {
            background-color: #f3e8ff;
            color: #6b21a8;
        }

        .badge-packed {
            background-color: #cffafe;
            color: #0369a1;
        }

        .badge-shipped {
            background-color: #ccfbf1;
            color: #0d4d49;
        }

        .badge-delivered {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-low {
            background-color: #fef3c7;
            color: #b45309;
        }

        .badge-out {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-ok {
            background-color: #dcfce7;
            color: #166534;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal.show {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .modal-body {
            margin-bottom: 1.5rem;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
        }

        .close-btn:hover {
            color: #1f2937;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #1f2937;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-family: inherit;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-secondary);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--color-secondary);
            color: var(--color-primary);
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        .btn-danger {
            background-color: var(--color-danger);
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .table thead {
            background-color: #f3f4f6;
        }

        .table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #1f2937;
            border-bottom: 1px solid #d1d5db;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .table tbody tr:hover {
            background-color: #f9fafb;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #065f46;
        }

        .alert-error {
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }

        .alert-warning {
            background-color: #fef3c7;
            border: 1px solid #fde68a;
            color: #b45309;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid var(--color-secondary);
        }

        .stat-content h3 {
            margin: 0 0 0.5rem 0;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.7;
        }
    </style>
    
    @yield('extra-css')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg flex flex-col">
            <div class="flex items-center justify-center h-16 bg-gray-900 text-white">
                <span class="text-xl font-bold">Staff Panel</span>
            </div>
            
            <nav class="mt-8 px-4 flex-1">
                <a href="{{ route('staff.dashboard') }}" class="flex items-center px-4 py-2 mb-2 text-gray-700 rounded-lg {{ request()->routeIs('staff.dashboard') ? 'bg-gray-200 text-gray-900 font-semibold' : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h6v6H4a1 1 0 01-1-1v-4zm8 0a1 1 0 011-1h2v6h-2a1 1 0 01-1-1v-4z" clip-rule="evenodd"></path>
                    </svg>
                    Dashboard
                </a>
                
                <div class="mt-6">
                    <h3 class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Quản lý</h3>
                    
                    <a href="{{ route('staff.orders.index') }}" class="flex items-center px-4 py-2 mb-2 text-gray-700 rounded-lg {{ request()->routeIs('staff.orders.*') ? 'bg-gray-200 text-gray-900 font-semibold' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM5 16a2 2 0 11-4 0 2 2 0 014 0zm7 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Quản lý đơn hàng
                    </a>
                    
                    <a href="{{ route('staff.inventory.index') }}" class="flex items-center px-4 py-2 mb-2 text-gray-700 rounded-lg {{ request()->routeIs('staff.inventory.*') ? 'bg-gray-200 text-gray-900 font-semibold' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                        </svg>
                        Quản lý kho hàng
                    </a>

                    <a href="{{ route('staff.inventory.report') }}" class="flex items-center px-4 py-2 mb-2 text-gray-700 rounded-lg {{ request()->routeIs('staff.inventory.report') ? 'bg-gray-200 text-gray-900 font-semibold' : 'hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Báo cáo tồn kho
                    </a>
                </div>
            </nav>
            
            <div class="px-4 py-4 border-t border-gray-200">
                <a href="/" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 mb-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    Về trang chủ
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
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Staff' }}</p>
                            <p class="text-xs text-gray-500">{{ '@' }}{{ Auth::user()->username ?? 'staff' }}</p>
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
                    <div class="alert alert-success mb-4">
                        {{ $message }}
                    </div>
                @endif
                
                @if ($message = Session::get('error'))
                    <div class="alert alert-error mb-4">
                        {{ $message }}
                    </div>
                @endif

                @if ($message = Session::get('warning'))
                    <div class="alert alert-warning mb-4">
                        {{ $message }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-error mb-4">
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

    @yield('extra-js')
</body>
</html>
