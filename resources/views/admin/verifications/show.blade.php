@extends('admin.layouts.app')

@section('title', 'Chi tiết Yêu cầu Đăng ký - Admin')
@section('page-title', 'Chi tiết Yêu cầu Đăng ký')

@section('content')
<div class="max-w-2xl">
    <!-- Back Button -->
    <a href="{{ route('admin.verifications.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-6">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Quay lại
    </a>

    <!-- Success/Error Messages -->
    @if ($message = Session::get('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
        {{ $message }}
    </div>
    @endif

    @if ($message = Session::get('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
        {{ $message }}
    </div>
    @endif

    <!-- Main Info Card -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">{{ $verification->username }}</h2>
                <div>
                    @if ($verification->isExpired())
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        ❌ Đã hết hạn
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        ✓ Đang hoạt động
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Info Details -->
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập</label>
                    <p class="text-gray-900 font-semibold">{{ $verification->username }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên người dùng</label>
                    <p class="text-gray-900">{{ $verification->name }}</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <p class="text-gray-900">{{ $verification->email }}</p>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vai trò yêu cầu</label>
                    <div>
                        @if (str_ends_with($verification->username, '.admin'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            👨‍💼 Quản trị viên
                        </span>
                        @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            👨‍💼 Nhân viên
                        </span>
                        @endif
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Yêu cầu lúc</label>
                    <p class="text-gray-900">{{ $verification->created_at->format('H:i - d/m/Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hết hạn lúc</label>
                    <p class="text-gray-900">
                        @if ($verification->isExpired())
                        <span class="text-red-600 font-medium">{{ $verification->expires_at->format('H:i - d/m/Y') }} (Đã hết)</span>
                        @else
                        <span class="text-green-600 font-medium">{{ $verification->expires_at->format('H:i - d/m/Y') }}</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lần thử nhập sai</label>
                    <p class="text-gray-900">{{ $verification->attempts }}/5</p>
                </div>
            </div>
        </div>
    </div>

    <!-- OTP Card -->
    <div class="bg-white rounded-lg shadow mb-6 border-l-4 border-yellow-400">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Mã OTP</h3>
            
            <div class="bg-gray-900 p-8 rounded-lg text-center mb-4">
                <p class="text-gray-400 text-sm mb-2">Cung cấp mã này cho nhân viên:</p>
                <p class="text-4xl font-bold text-yellow-400 font-mono tracking-widest">
                    {{ $verification->otp }}
                </p>
            </div>

            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg mb-4 text-sm text-blue-800">
                <p class="font-semibold mb-2">⚠️ Lưu ý quan trọng:</p>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    <li>Cung cấp mã này cho nhân viên qua kênh an toàn (không qua email)</li>
                    <li>Mã sẽ hết hạn lúc {{ $verification->expires_at->format('H:i - d/m/Y') }}</li>
                    <li>Nhân viên có tối đa 5 lần thử nhập mã</li>
                    <li>Nếu mã bị lộ, hãy nhấn "Tạo OTP mới" ngay lập tức</li>
                </ul>
            </div>

            <!-- Resend OTP Form -->
            <form method="POST" action="{{ route('admin.verifications.resend-otp', $verification) }}">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg font-medium hover:bg-yellow-700">
                    🔄 Tạo OTP mới
                </button>
            </form>
        </div>
    </div>

    <!-- Actions -->
    @if (!$verification->isExpired())
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quyết định phê duyệt</h3>
        
        <div class="grid grid-cols-2 gap-4">
            <!-- Approve Button -->
            <form method="POST" action="{{ route('admin.verifications.approve', $verification) }}" onsubmit="return confirm('Phê duyệt yêu cầu này?')">
                @csrf
                <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700">
                    ✓ Phê duyệt
                </button>
            </form>

            <!-- Reject Button -->
            <form method="POST" action="{{ route('admin.verifications.reject', $verification) }}" onsubmit="return confirm('Từ chối yêu cầu này?')">
                @csrf
                <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">
                    ✗ Từ chối
                </button>
            </form>
        </div>
    </div>
    @else
    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
        <p class="text-red-800 font-semibold">⏰ Yêu cầu này đã hết hạn. Nhân viên cần đăng ký lại.</p>
    </div>
    @endif
</div>
@endsection
