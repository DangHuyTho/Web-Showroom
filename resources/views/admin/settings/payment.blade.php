@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-700 mb-4 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                Quay lại
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Cài Đặt Thanh Toán</h1>
            <p class="mt-2 text-gray-600">Quản lý phương thức thanh toán và API key</p>
        </div>

        <!-- Settings Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('admin.settings.update-payment') }}">
                @csrf
                @method('PUT')

                <!-- Payment Methods -->
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Phương thức thanh toán</h2>
                    <div class="space-y-3">
                        @foreach($settings['enabled_methods'] as $key => $method)
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="payment_methods[]" value="{{ $key }}" 
                                   {{ $method['enabled'] ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-3 text-sm font-medium text-gray-900">{{ $method['name'] }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- API Keys -->
                <div class="p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900">Khóa API</h2>

                    <!-- Stripe -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stripe Key</label>
                        <input type="text" name="stripe_key" value="{{ $settings['gateway_keys']['stripe'] }}" 
                               placeholder="sk_live_..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- PayPal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">PayPal Client ID</label>
                        <input type="text" name="paypal_client_id" value="{{ $settings['gateway_keys']['paypal'] }}" 
                               placeholder="AW..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- VNPay -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">VNPay Merchant ID</label>
                        <input type="text" name="vnpay_merchant_id" value="{{ $settings['gateway_keys']['vnpay'] }}" 
                               placeholder="Merchant ID"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-6">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Lưu cài đặt
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            Hủy
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-amber-50 border border-amber-200 rounded-lg p-6">
            <h3 class="text-sm font-semibold text-amber-900 mb-3">⚠️ Lưu ý bảo mật</h3>
            <ul class="space-y-2 text-sm text-amber-800 list-disc list-inside">
                <li>Không bao giờ chia sẻ Secret Key công khai</li>
                <li>Cập nhật API key trong file .env thay vì cơ sở dữ liệu nếu có thể</li>
                <li>Kiểm tra kết nối gateway thanh toán trước khi kích hoạt trên trang web</li>
            </ul>
        </div>
    </div>
</div>
@endsection
