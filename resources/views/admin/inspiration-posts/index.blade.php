@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-700 mb-4 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Quay lại
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Bài Viết Cảm Hứng</h1>
                <p class="mt-2 text-gray-600">Quản lý các bài viết cảm hứng, dự án, và blog</p>
            </div>
            <a href="{{ route('admin.inspiration-posts.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Tạo Bài Viết Mới
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow mb-6 p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Tìm kiếm tiêu đề..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <select name="post_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Tất cả loại --</option>
                        <option value="inspiration" {{ request('post_type') === 'inspiration' ? 'selected' : '' }}>Cảm hứng</option>
                        <option value="case-study" {{ request('post_type') === 'case-study' ? 'selected' : '' }}>Case Study</option>
                        <option value="blog" {{ request('post_type') === 'blog' ? 'selected' : '' }}>Blog</option>
                        <option value="project" {{ request('post_type') === 'project' ? 'selected' : '' }}>Dự Án</option>
                    </select>
                </div>

                <div>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tắt</option>
                        <option value="featured" {{ request('status') === 'featured' ? 'selected' : '' }}>Nổi bật</option>
                    </select>
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Lọc
                </button>
            </form>
        </div>

        <!-- Posts Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($posts->count() > 0)
            <table class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Tiêu đề</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Loại</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Địa điểm</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">Trạng thái</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($posts as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-12 h-12 rounded object-cover mr-3">
                                @endif
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">{{ $post->title }}</h3>
                                    <p class="text-xs text-gray-500">{{ Str::limit($post->excerpt, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                  style="background-color: {{ $post->post_type === 'inspiration' ? '#e0f2fe' : ($post->post_type === 'case-study' ? '#fef3c7' : ($post->post_type === 'blog' ? '#dbeafe' : '#e0e7ff')) }}; color: {{ $post->post_type === 'inspiration' ? '#0369a1' : ($post->post_type === 'case-study' ? '#9a3412' : ($post->post_type === 'blog' ? '#1e40af' : '#4338ca')) }}">
                                {{ ucfirst($post->post_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $post->project_location ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2 flex-wrap">
                                <form method="POST" action="{{ route('admin.inspiration-posts.toggleActive', $post) }}" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-all cursor-pointer border-0" 
                                            style="background-color: {{ $post->is_active ? '#d1fae5' : '#fee2e2' }}; color: {{ $post->is_active ? '#065f46' : '#991b1b' }};"
                                            onmouseover="this.style.boxShadow='0 0 8px rgba(0,0,0,0.15)'; this.style.transform='scale(1.05)'"
                                            onmouseout="this.style.boxShadow='none'; this.style.transform='scale(1)'">
                                        {{ $post->is_active ? '✓ Hoạt động' : '✗ Tắt' }}
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.inspiration-posts.toggleFeatured', $post) }}" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-all cursor-pointer border-0"
                                            style="background-color: {{ $post->is_featured ? '#fef3c7' : '#f3f4f6' }}; color: {{ $post->is_featured ? '#9a3412' : '#6b7280' }};"
                                            onmouseover="this.style.boxShadow='0 0 8px rgba(0,0,0,0.15)'; this.style.transform='scale(1.05)'"
                                            onmouseout="this.style.boxShadow='none'; this.style.transform='scale(1)'">
                                        {{ $post->is_featured ? '⭐ Nổi bật' : '☆ Thường' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.inspiration-posts.edit', $post) }}" 
                                   class="text-blue-600 hover:text-blue-900 font-medium text-sm">
                                    Sửa
                                </a>
                                <form method="POST" action="{{ route('admin.inspiration-posts.destroy', $post) }}" 
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');" 
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $posts->links() }}
            </div>
            @else
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-600 font-medium">Không có bài viết nào</p>
                <a href="{{ route('admin.inspiration-posts.create') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700">
                    Tạo bài viết đầu tiên →
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
