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
            <h1 class="text-3xl font-bold text-gray-900">Cài Đặt Vận Chuyển</h1>
            <p class="mt-2 text-gray-600">Quản lý nhà cung cấp vận chuyển và phí giao hàng</p>
        </div>

        <!-- Settings Form -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Nhà cung cấp vận chuyển</h2>
            </div>

            <form method="POST" action="{{ route('admin.settings.update-shipping') }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Default Provider -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nhà cung cấp mặc định</label>
                    <select name="default_shipping_provider" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @foreach($settings['providers'] as $key => $provider)
                        <option value="{{ $key }}" {{ $settings['default_shipping_provider'] === $key ? 'selected' : '' }}>
                            {{ $provider['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Shipping Rates -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Phí giao hàng</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phí giao hàng tiêu chuẩn</label>
                            <div class="flex items-center">
                                <input type="number" name="standard_shipping_fee" 
                                       value="{{ $settings['shipping_rates']['standard']['base_fee'] }}" 
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <span class="ml-2 text-gray-600">đ</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phí giao hàng nhanh</label>
                            <div class="flex items-center">
                                <input type="number" name="express_shipping_fee" 
                                       value="{{ $settings['shipping_rates']['express']['base_fee'] }}" 
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <span class="ml-2 text-gray-600">đ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Free Shipping Threshold -->
                <div class="border-t border-gray-200 pt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Miễn phí giao hàng từ giá trị đơn</label>
                    <div class="flex items-center">
                        <input type="number" name="free_shipping_threshold" 
                               value="{{ $settings['shipping_rates']['free_threshold'] }}" 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <span class="ml-2 text-gray-600">đ</span>
                    </div>
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
            </form>
        </div>

        <!-- Provider Information -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-sm font-semibold text-blue-900 mb-3">📌 Thông tin nhà cung cấp</h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li><strong>GHTK:</strong> Hãng tải Giao Hàng Tiết Kiệm</li>
                <li><strong>Viettel Post:</strong> Dịch vụ vận chuyển của Viettel</li>
                <li><strong>Ninja Van:</strong> Dịch vụ giao hàng nhanh Ninja Van</li>
            </ul>
        </div>
    </div>
</div>
@endsection
