@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm mới')
@section('page-title', 'Thêm sản phẩm mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Tạo sản phẩm mới</h2>
        </div>
        
        <form action="{{ route('admin.products.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Basic Information -->
            <div>
                <h3 class="text-base font-semibold text-gray-900 mb-4">Thông tin cơ bản</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tên sản phẩm <span class="text-red-600">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror" required>
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug <span class="text-red-600">*</span></label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('slug') border-red-500 @enderror" required>
                        @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU <span class="text-red-600">*</span></label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('sku') border-red-500 @enderror" required>
                        @error('sku') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Giá (đ) <span class="text-red-600">*</span></label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('price') border-red-500 @enderror" required>
                        @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Danh mục <span class="text-red-600">*</span></label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('category_id') border-red-500 @enderror" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-2">Thương hiệu <span class="text-red-600">*</span></label>
                        <select name="brand_id" id="brand_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('brand_id') border-red-500 @enderror" required>
                            <option value="">-- Chọn thương hiệu --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            
            <!-- Descriptions -->
            <div class="border-t pt-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Mô tả</h3>
                
                <div class="mb-6">
                    <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">Mô tả ngắn</label>
                    <textarea name="short_description" id="short_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('short_description') }}</textarea>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Mô tả chi tiết</label>
                    <textarea name="description" id="description" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('description') }}</textarea>
                </div>
            </div>
            
            <!-- Product Details -->
            <div class="border-t pt-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Thông tin chi tiết</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Đơn vị tính</label>
                        <input type="text" name="unit" id="unit" value="{{ old('unit') }}" placeholder="VD: m², cái, ..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700 mb-2">Vật liệu</label>
                        <input type="text" name="material" id="material" value="{{ old('material') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label for="size" class="block text-sm font-medium text-gray-700 mb-2">Kích thước</label>
                        <input type="text" name="size" id="size" value="{{ old('size') }}" placeholder="VD: 60x60cm" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label for="surface_type" class="block text-sm font-medium text-gray-700 mb-2">Loại bề mặt</label>
                        <input type="text" name="surface_type" id="surface_type" value="{{ old('surface_type') }}" placeholder="VD: Bóng, mờ, ..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label for="water_absorption" class="block text-sm font-medium text-gray-700 mb-2">Độ hút nước</label>
                        <input type="text" name="water_absorption" id="water_absorption" value="{{ old('water_absorption') }}" placeholder="VD: < 0.5%" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label for="hardness" class="block text-sm font-medium text-gray-700 mb-2">Độ cứng</label>
                        <input type="text" name="hardness" id="hardness" value="{{ old('hardness') }}" placeholder="VD: PEI 4" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label for="glaze_technology" class="block text-sm font-medium text-gray-700 mb-2">Công nghệ phủ men</label>
                        <input type="text" name="glaze_technology" id="glaze_technology" value="{{ old('glaze_technology') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Thứ tự sắp xếp</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
            </div>
            
            <!-- Status -->
            <div class="border-t pt-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Trạng thái</h3>
                
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded">
                        <span class="ml-2 text-sm text-gray-700">Kích hoạt sản phẩm</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded">
                        <span class="ml-2 text-sm text-gray-700">Sản phẩm nổi bật</span>
                    </label>
                </div>
            </div>
            
            <!-- Submit -->
            <div class="border-t pt-6 flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Tạo sản phẩm</button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-medium">Hủy</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('name').addEventListener('blur', function() {
        const slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_]+/g, '-')
            .replace(/^-+|-+$/g, '');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection
