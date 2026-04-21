@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.settings.content') }}" class="text-blue-600 hover:text-blue-700 mb-4 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                Quay lại
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Chỉnh sửa nội dung</h1>
            <p class="mt-2 text-gray-600">{{ $content['title'] }}</p>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('admin.settings.update-content', $content['slug']) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tiêu đề</label>
                    <input type="text" name="title" value="{{ $content['title'] }}" 
                           required maxlength="255"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Slug (Read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" value="{{ $content['slug'] }}" disabled 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                </div>

                <!-- Body/Content -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nội dung</label>
                    <div class="bg-gray-50 rounded-lg border border-gray-300 p-4">
                        <textarea id="content-editor" name="body" rows="12" 
                                  class="w-full px-0 py-0 border-0 focus:ring-0 focus:border-0 bg-transparent text-gray-900 font-mono text-sm"
                                  placeholder="Nhập nội dung HTML tại đây...">{{ $content['body'] }}</textarea>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">💡 Bạn có thể sử dụng HTML hoặc Markdown</p>
                </div>

                <!-- Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Xem trước</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 min-h-40" id="preview">
                        {!! $content['body'] !!}
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Lưu nội dung
                    </button>
                    <a href="{{ route('admin.settings.content') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Update preview on input
    const editor = document.getElementById('content-editor');
    const preview = document.getElementById('preview');
    
    editor.addEventListener('input', function() {
        preview.innerHTML = this.value || '<span class="text-gray-400 italic">Nội dung sẽ hiển thị tại đây...</span>';
    });
</script>
@endsection
