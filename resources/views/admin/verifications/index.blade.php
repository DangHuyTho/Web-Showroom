@extends('admin.layouts.app')

@section('title', 'Quản lý Yêu cầu Đăng ký - Admin')
@section('page-title', 'Quản lý Yêu cầu Đăng ký Nhân viên')

@section('content')
<div class="bg-white rounded-lg shadow">
    <!-- Header with Filters -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Yêu cầu đăng ký chờ phê duyệt</h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ $requests->total() }} yêu cầu
            </span>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('admin.verifications.index') }}" class="flex gap-3">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Tất cả trạng thái</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Đã hết hạn</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                Lọc
            </button>
        </form>
    </div>

    <!-- Success/Error Messages -->
    @if ($message = Session::get('success'))
    <div class="m-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
        {{ $message }}
    </div>
    @endif

    @if ($message = Session::get('error'))
    <div class="m-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
        {{ $message }}
    </div>
    @endif

    <!-- Requests Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tên đăng nhập</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tên</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Vai trò</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Hết hạn</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        {{ $request->username }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ $request->name }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ $request->email }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if (str_ends_with($request->username, '.admin'))
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            Quản trị viên
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Nhân viên
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        @if ($request->isExpired())
                        <span class="text-red-600 font-medium">Đã hết hạn</span>
                        @else
                        <span class="text-green-600 font-medium">{{ $request->expires_at->format('H:i - d/m/Y') }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <a href="{{ route('admin.verifications.show', $request) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Xem chi tiết
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        Không có yêu cầu đăng ký nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($requests->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $requests->links() }}
    </div>
    @endif
</div>
@endsection
