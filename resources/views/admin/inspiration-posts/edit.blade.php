@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.inspiration-posts.index') }}" class="text-blue-600 hover:text-blue-700 mb-4 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                Quay lại danh sách
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Chỉnh Sửa Bài Viết</h1>
        </div>

        <!-- Form -->
        @if($post ?? null)
        <form method="POST" action="{{ route('admin.inspiration-posts.update', $post) }}" enctype="multipart/form-data" class="space-y-8">
        @else
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
            <p class="text-red-800">⚠️ Lỗi: Không tìm thấy bài viết</p>
        </div>
        <form method="POST" action="#" enctype="multipart/form-data" class="space-y-8" style="opacity: 0.5; pointer-events: none;">
        @endif
            @csrf
            @method('PUT')

            <!-- Basic Info Section -->
            <div class="bg-white rounded-lg shadow p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 pb-4 border-b border-gray-200">Thông Tin Cơ Bản</h2>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tiêu đề *</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" 
                           required maxlength="255"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
                    @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Excerpt -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả ngắn *</label>
                    <textarea name="excerpt" rows="3" 
                              required maxlength="500"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Tối đa 500 ký tự</p>
                    @error('excerpt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Post Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Loại bài viết *</label>
                    <select name="post_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('post_type') border-red-500 @enderror">
                        <option value="">-- Chọn loại --</option>
                        @foreach($types as $type)
                        <option value="{{ $type }}" {{ old('post_type', $post->post_type) === $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('-', ' ', $type)) }}
                        </option>
                        @endforeach
                    </select>
                    @error('post_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Featured Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hình ảnh nổi bật</label>
                    
                    @if($post->featured_image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
                             alt="{{ $post->title }}" 
                             class="max-h-64 rounded-lg">
                        <p class="mt-2 text-sm text-gray-500">Hình ảnh hiện tại</p>
                    </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:bg-gray-50" onclick="document.getElementById('featured-image').click()">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-600 font-medium">Nhấp để thay đổi hình ảnh</p>
                        <p class="text-gray-500 text-xs mt-1">JPG, PNG, GIF (tối đa 2MB)</p>
                    </div>
                    <input type="file" id="featured-image" name="featured_image" accept="image/*" class="hidden" onchange="updateImagePreview(this)">
                    <img id="image-preview" src="" alt="Preview" class="mt-4 max-h-64 mx-auto hidden rounded-lg">
                    @error('featured_image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Content Section -->
            <div class="bg-white rounded-lg shadow p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-4 border-b border-gray-200">Nội Dung</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nội dung bài viết *</label>
                    <textarea name="content" rows="10" 
                              required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 font-mono text-sm @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
                    @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Project Info Section -->
            <div class="bg-white rounded-lg shadow p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 pb-4 border-b border-gray-200">Thông Tin Dự Án</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Project Location -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Địa điểm dự án</label>
                        <input type="text" name="project_location" value="{{ old('project_location', $post->project_location) }}" 
                               maxlength="255"
                               placeholder="Vd: Quận 2, TP.HCM"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Project Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ngày hoàn thành</label>
                        <input type="date" name="project_date" value="{{ old('project_date', $post->project_date ? $post->project_date->format('Y-m-d') : '') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Related Products -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sản phẩm liên quan</label>
                    <select name="related_products[]" multiple class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ in_array($product->id, old('related_products', $post->related_products ?? [])) ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Giữ Ctrl (hoặc Cmd trên Mac) để chọn nhiều sản phẩm</p>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="bg-white rounded-lg shadow p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-4 border-b border-gray-200">Cài Đặt</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sort Order -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Thứ tự sắp xếp</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $post->sort_order) }}" 
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-xs text-gray-500">Số nhỏ hơn sẽ hiển thị trước</p>
                    </div>
                </div>

                <!-- Status Checkboxes -->
                <div class="space-y-3 pt-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $post->is_active) ? 'checked' : '' }} 
                               class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm font-medium text-gray-700">Kích hoạt bài viết</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }} 
                               class="w-4 h-4 text-yellow-500 rounded focus:ring-yellow-500">
                        <span class="ml-2 text-sm font-medium text-gray-700">Đánh dấu là nổi bật</span>
                    </label>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Cập nhật bài viết
                </button>
                <a href="{{ route('admin.inspiration-posts.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Hủy
                </a>
            </div>
        </form>
        @endif
    </div>
</div>

<script>
function updateImagePreview(input) {
    const preview = document.getElementById('image-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
