@extends('layouts.app')

@section('title', 'Đăng Nhập Admin')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <div style="width: 100%; max-width: 400px; padding: var(--spacing-md);">
        <!-- Logo -->
        <div style="text-align: center; margin-bottom: var(--spacing-lg);">
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--color-secondary); font-family: 'Playfair Display', serif;">Admin</h1>
            <p style="color: rgba(255,255,255,0.6); margin-top: var(--spacing-sm);">Đăng nhập để quản lý nội dung</p>
        </div>

        <!-- Login Form -->
        <div style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: var(--spacing-lg); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);">
            <!-- Success Message -->
            @if ($message = Session::get('success'))
            <div style="background: #10b981; color: white; padding: var(--spacing-sm); border-radius: 8px; margin-bottom: var(--spacing-md); font-size: 0.9rem;">
                {{ $message }}
            </div>
            @endif

            <!-- Error Message -->
            @if ($message = Session::get('error'))
            <div style="background: #ef4444; color: white; padding: var(--spacing-sm); border-radius: 8px; margin-bottom: var(--spacing-md); font-size: 0.9rem;">
                {{ $message }}
            </div>
            @endif

            <!-- Errors -->
            @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: var(--spacing-sm); border-radius: 8px; margin-bottom: var(--spacing-md); font-size: 0.9rem;">
                <ul style="margin: 0; padding-left: var(--spacing-sm);">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('auth.login') }}">
                @csrf

                <!-- Username -->
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Tên đăng nhập</label>
                    <input type="text" name="username" value="{{ old('username') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                </div>

                <!-- Password -->
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Mật khẩu</label>
                    <input type="password" name="password" required style="width: 100%; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                </div>

                <!-- Remember Me & Forgot Password -->
                <div style="margin-bottom: var(--spacing-lg); display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: var(--spacing-xs);">
                        <input type="checkbox" name="remember" id="remember" style="cursor: pointer;">
                        <label for="remember" style="color: rgba(255,255,255,0.7); font-size: 0.9rem; cursor: pointer;">Ghi nhớ tôi</label>
                    </div>
                    <a href="{{ route('auth.forgot-password') }}" style="color: var(--color-secondary); text-decoration: none; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Quên mật khẩu?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" style="width: 100%; padding: 12px 16px; background: var(--color-secondary); color: var(--color-primary); border: none; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(212,175,55,0.3)'" onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    Đăng Nhập
                </button>
            </form>


        </div>

        <!-- Back Link -->
        <div style="text-align: center; margin-top: var(--spacing-lg);">
            <a href="{{ url('/') }}" style="color: var(--color-secondary); text-decoration: none; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">← Quay lại trang chủ</a>
        </div>
    </div>
</div>
@endsection
