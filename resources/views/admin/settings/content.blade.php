@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-700 mb-4 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Quay lại
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Quản lý Nội Dung</h1>
                <p class="mt-2 text-gray-600">Đăng các bài viết cảm hứng, blog, dự án & case study</p>
            </div>
            <a href="{{ route('admin.inspiration-posts.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Tạo Bài Viết Mới
            </a>
        </div>

        <!-- Main Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Inspiration Posts -->
            <a href="{{ route('admin.inspiration-posts.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow cursor-pointer">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a2 2 0 01-2-2V4zm3 1h6v2H7V5zm0 4h6v2H7V9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Bài Viết Cảm Hứng</h3>
                        <p class="mt-1 text-sm text-gray-600">Quản lý tất cả bài viết, dự án và inspirations</p>
                    </div>
                </div>
            </a>

            <!-- SEO & Meta Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.798 6.798l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">SEO & Meta</h3>
                        <p class="mt-1 text-sm text-gray-600">Cập nhật title, description cho mỗi bài viết</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-600">Tổng bài viết</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\InspirationPost::count() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-600">Bài viết nổi bật</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\InspirationPost::where('is_featured', true)->count() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-600">Bài viết hoạt động</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\InspirationPost::where('is_active', true)->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
