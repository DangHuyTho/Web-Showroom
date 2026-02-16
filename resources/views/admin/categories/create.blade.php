@extends('admin.layouts.app')

@section('title', 'Thêm danh mục mới')
@section('page-title', 'Thêm danh mục mới')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Tạo danh mục mới</h2>
        </div>
        
        <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tên danh mục <span class="text-red-600">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug <span class="text-red-600">*</span></label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('slug') border-red-500 @enderror" required>
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Loại danh mục <span class="text-red-600">*</span></label>
                <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('type') border-red-500 @enderror" required>
                    <option value="">-- Chọn loại --</option>
                    <option value="product" {{ old('type') == 'product' ? 'selected' : '' }}>Sản phẩm</option>
                    <option value="inspiration" {{ old('type') == 'inspiration' ? 'selected' : '' }}>Cảm hứng</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Danh mục cha (tùy chọn)</label>
                <select name="parent_id" id="parent_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="">-- Không có --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Mô tả (tùy chọn)</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
            </div>
            
            <div class="mb-6">
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon (tùy chọn)</label>
                <input type="text" name="icon" id="icon" value="{{ old('icon') }}" placeholder="e.g., fas fa-cube" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            
            <div class="mb-6">
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Thứ tự sắp xếp (tùy chọn)</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300">
                    <span class="ml-2 text-sm text-gray-700">Kích hoạt danh mục</span>
                </label>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Tạo danh mục</button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-medium">Hủy</a>
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
