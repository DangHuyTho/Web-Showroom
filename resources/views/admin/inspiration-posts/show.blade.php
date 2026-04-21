@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <a href="{{ route('admin.inspiration-posts.index') }}" class="text-blue-600 hover:text-blue-700 mb-4 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Quay lại danh sách
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
                <p class="mt-2 text-gray-600">Slug: <code class="bg-gray-100 px-2 py-1 rounded">{{ $post->slug }}</code></p>
            </div>
            <a href="{{ route('admin.inspiration-posts.edit', $post) }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                </svg>
                Chỉnh sửa
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Featured Image -->
                @if($post->featured_image)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-96 object-cover">
                </div>
                @endif

                <!-- Excerpt -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Mô tả ngắn</h2>
                    <p class="text-gray-700">{{ $post->excerpt }}</p>
                </div>

                <!-- Content -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Nội dung</h2>
                    <div class="prose prose-sm max-w-none">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>

                <!-- Project Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Thông tin dự án</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-600 mb-1">Địa điểm</h3>
                            <p class="text-gray-900">{{ $post->project_location ?? 'Không có' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-600 mb-1">Ngày hoàn thành</h3>
                            <p class="text-gray-900">{{ $post->project_date ? $post->project_date->format('d/m/Y') : 'Không có' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                @if($post->related_products && count($post->related_products) > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Sản phẩm liên quan</h2>
                    <div class="space-y-2">
                        @foreach($post->related_products as $productId)
                        @php $product = \App\Models\Product::find($productId); @endphp
                        @if($product)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-gray-900">{{ $product->name }}</span>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-700 text-sm">Xem →</a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Trạng thái</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Kích hoạt</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                                  style="background-color: {{ $post->is_active ? '#d1fae5' : '#fee2e2' }}; color: {{ $post->is_active ? '#065f46' : '#991b1b' }}">
                                {{ $post->is_active ? 'Hoạt động' : 'Tắt' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Nổi bật</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                                  style="background-color: {{ $post->is_featured ? '#fef3c7' : '#f3f4f6' }}; color: {{ $post->is_featured ? '#9a3412' : '#6b7280' }}">
                                {{ $post->is_featured ? '⭐ Nổi bật' : 'Thường' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Thông tin</h2>
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-gray-600">Loại</dt>
                            <dd class="text-gray-900 font-medium">{{ ucfirst(str_replace('-', ' ', $post->post_type)) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-600">Thứ tự</dt>
                            <dd class="text-gray-900 font-medium">{{ $post->sort_order }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-600">Tạo lúc</dt>
                            <dd class="text-gray-900 font-medium">{{ $post->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-600">Cập nhật lúc</dt>
                            <dd class="text-gray-900 font-medium">{{ $post->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Hành động</h2>
                    <div class="space-y-2">
                        <form method="POST" action="{{ route('admin.inspiration-posts.destroy', $post) }}" 
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                                Xóa bài viết
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
