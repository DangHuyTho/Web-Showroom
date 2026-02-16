@extends('admin.layouts.app')

@section('title', 'Quản lý danh mục')
@section('page-title', 'Quản lý danh mục')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="flex-1">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" placeholder="Tìm kiếm danh mục..." value="{{ request('search') }}" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Tìm kiếm</button>
        </form>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="ml-4 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">+ Thêm danh mục mới</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($categories->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loại</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Danh mục cha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thứ tự</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $category->slug }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded text-xs">{{ $category->type }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $category->parent->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $category->sort_order ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm">
                                <form action="{{ route('admin.categories.toggleActive', $category) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2 py-1 rounded text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $category->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900 mr-3">Sửa</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-900">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $categories->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center text-gray-500">
            <p>Chưa có danh mục nào. <a href="{{ route('admin.categories.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">Tạo danh mục đầu tiên</a></p>
        </div>
    @endif
</div>
@endsection
