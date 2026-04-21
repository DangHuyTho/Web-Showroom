@extends('admin.layouts.app')

@section('title', 'Chi Tiết Tài Khoản')

@section('content')
<div class="container-fluid max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                Sửa
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                Quay lại
            </a>
        </div>
    </div>

    @if (session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <p class="text-green-800">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tên</label>
                <p class="text-gray-900">{{ $user->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                <p class="text-gray-900">{{ $user->username }}</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <p class="text-gray-900">{{ $user->email }}</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Vai trò</label>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $user->isAdmin() ? 'bg-red-100 text-red-800' : ($user->isStaff() ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Trạng thái</label>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $user->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ngày tạo</label>
                <p class="text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cập nhật lần cuối</label>
                <p class="text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
            </div>

            @if ($user->isStaff() || $user->isAdmin())
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Thông tin phụ</label>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-600">Vai trò: <strong>{{ ucfirst($user->role) }}</strong></p>
                    <p class="text-gray-600 mt-2">Mật khẩu được cài đặt: {{ $user->password_set ? 'Có' : 'Không' }}</p>
                </div>
            </div>
            @endif
        </div>

        <hr class="my-6">

        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Chỉnh sửa tài khoản
            </a>
            
            @if (!($user->isAdmin() && \App\Models\User::where('role', 'admin')->count() <= 1))
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" 
                onsubmit="return confirm('Xóa tài khoản này? Hành động này không thể hoàn tác!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    Xóa tài khoản
                </button>
            </form>
            @else
            <button disabled class="bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed" 
                title="Không thể xóa admin cuối cùng">
                Xóa tài khoản
            </button>
            @endif
        </div>
    </div>
</div>
@endsection
