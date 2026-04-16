@extends('layouts.app')

@section('title', 'Quản lý thông tin cá nhân')

@section('content')
<div style="min-height: 100vh; background: #f5f5f5; padding: 40px 20px;">
    <div style="max-width: 600px; margin: 0 auto;">
        <!-- Header -->
        <div style="margin-bottom: 30px;">
            <a href="{{ route('home') }}" style="color: var(--color-secondary); text-decoration: none; font-weight: 600; font-size: 0.95rem;">← Quay lại</a>
            <h1 style="font-size: 2rem; margin: 15px 0 0 0; color: var(--color-primary);">Quản lý thông tin cá nhân</h1>
            <p style="color: #6b7280; margin: 10px 0 0 0;">Cập nhật hồ sơ và ảnh đại diện</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #22c55e;">
            {{ session('success') }}
        </div>
        @endif

        <!-- Error from session -->
        @if (session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
            {{ session('error') }}
        </div>
        @endif

        <!-- Validation Error Messages -->
        @if ($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                <li style="margin-bottom: 5px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Profile Card -->
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

            <!-- Avatar Section -->
            <div style="text-align: center; margin-bottom: 30px;">
                @php
                    $avatar = Auth::user()->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=d4af37&color=1a1a1a&size=120';
                @endphp
                <img src="{{ $avatar }}" alt="{{ Auth::user()->name }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid var(--color-secondary); margin-bottom: 15px;">
                <p style="color: #6b7280; font-size: 0.95rem;">@{{ Auth::user()->username }}</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 20px;">
                @csrf
                @method('PATCH')

                <!-- Name -->
                <div>
                    <label style="display: block; color: var(--color-primary); margin-bottom: 8px; font-weight: 600; font-size: 0.95rem;">Họ và Tên</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" 
                        style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease;"
                        onmouseover="this.style.borderColor='var(--color-secondary)'" 
                        onmouseout="this.style.borderColor='#e5e7eb'"
                        onfocus="this.style.borderColor='var(--color-secondary)'"
                        onblur="this.style.borderColor='#e5e7eb'">
                    @error('name')
                    <span style="color: #dc2626; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label style="display: block; color: var(--color-primary); margin-bottom: 8px; font-weight: 600; font-size: 0.95rem;">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" 
                        style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease;"
                        onmouseover="this.style.borderColor='var(--color-secondary)'" 
                        onmouseout="this.style.borderColor='#e5e7eb'"
                        onfocus="this.style.borderColor='var(--color-secondary)'"
                        onblur="this.style.borderColor='#e5e7eb'">
                    @error('email')
                    <span style="color: #dc2626; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Username (Read-only) -->
                <div>
                    <label style="display: block; color: var(--color-primary); margin-bottom: 8px; font-weight: 600; font-size: 0.95rem;">Tên đăng nhập</label>
                    <input type="text" value="{{ Auth::user()->username }}" 
                        style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 1rem; box-sizing: border-box; background: #f9fafb; color: #6b7280;" 
                        disabled>
                    <p style="color: #6b7280; font-size: 0.85rem; margin-top: 5px;">Không thể thay đổi</p>
                </div>

                <!-- Avatar Upload -->
                <div>
                    <label style="display: block; color: var(--color-primary); margin-bottom: 8px; font-weight: 600; font-size: 0.95rem;">Ảnh đại diện</label>
                    <div style="border: 2px dashed #e5e7eb; border-radius: 8px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.3s ease;"
                        onmouseover="this.style.borderColor='var(--color-secondary)'; this.style.background='#fffaf0'"
                        onmouseout="this.style.borderColor='#e5e7eb'; this.style.background='white'"
                        onclick="document.getElementById('avatar-input').click()">
                        <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display: none;" onchange="previewAvatar(event)">
                        <p style="color: #6b7280; font-size: 0.95rem; margin: 0;">
                            Nhấp để chọn ảnh
                        </p>
                        <p style="color: #9ca3af; font-size: 0.85rem; margin: 5px 0 0 0;">
                            JPEG, PNG, GIF (Tối đa 2MB)
                        </p>
                    </div>
                    @error('avatar')
                    <span style="color: #dc2626; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Avatar Preview -->
                <div id="avatar-preview" style="display: none; text-align: center;">
                    <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 10px;">Xem trước:</p>
                    <img id="preview-img" src="" alt="Preview" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--color-secondary);">
                </div>

                <!-- Buttons -->
                <div style="display: flex; gap: 12px; margin-top: 20px;">
                    <button type="submit" style="flex: 1; padding: 12px 20px; background: var(--color-secondary); color: var(--color-primary); border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 0.95rem;"
                        onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                        💾 Lưu thay đổi
                    </button>
                    <a href="{{ route('home') }}" style="flex: 1; padding: 12px 20px; background: #f3f4f6; color: var(--color-primary); border: none; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; text-align: center; transition: all 0.3s ease; font-size: 0.95rem;"
                        onmouseover="this.style.background='#e5e7eb'; this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.background='#f3f4f6'; this.style.transform='translateY(0)'">
                        ✕ Hủy
                    </a>
                </div>

                <!-- Info -->
                <div style="background: #f0f9ff; padding: 15px; border-radius: 8px; border-left: 4px solid #0ea5e9;">
                    <p style="color: #0c4a6e; font-size: 0.9rem; margin: 0;">
                        <strong>ℹ️ Lưu ý:</strong> Tên đăng nhập không thể thay đổi. Nếu bạn đăng nhập bằng Google, ảnh đại diện sẽ tự động cập nhật từ Google.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('avatar-preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
