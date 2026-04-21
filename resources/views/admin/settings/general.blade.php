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
            <h1 class="text-3xl font-bold text-gray-900">Cài Đặt Chung</h1>
            <p class="mt-2 text-gray-600">Quản lý thông tin cơ bản của trang web</p>
        </div>

        <!-- Settings Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('admin.settings.update-general') }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Site Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên trang web</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] }}" 
                           required maxlength="255"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email liên hệ</label>
                    <input type="email" name="site_email" value="{{ $settings['site_email'] }}" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                    <input type="tel" name="site_phone" value="{{ $settings['site_phone'] }}" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                    <textarea name="site_address" rows="3" 
                              required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $settings['site_address'] }}</textarea>
                </div>

                <!-- Theme -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Chủ đề</label>
                    <select name="theme" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="light" {{ $settings['theme'] === 'light' ? 'selected' : '' }}>Sáng</option>
                        <option value="dark" {{ $settings['theme'] === 'dark' ? 'selected' : '' }}>Tối</option>
                    </select>
                </div>

                <!-- Items Per Page -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Số mục trên mỗi trang</label>
                    <input type="number" name="items_per_page" value="{{ $settings['items_per_page'] }}" 
                           min="5" max="100" required
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
            </form>
        </div>
    </div>
</div>
@endsection
