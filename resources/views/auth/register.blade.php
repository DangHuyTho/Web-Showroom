@extends('layouts.app')

@section('title', 'Đăng Ký')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <div style="width: 100%; max-width: 450px; padding: var(--spacing-md);">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: var(--spacing-lg);">
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--color-secondary); font-family: 'Playfair Display', serif;">Đăng Ký</h1>
            <p style="color: rgba(255,255,255,0.6); margin-top: var(--spacing-sm);">Tạo tài khoản để bắt đầu mua sắm</p>
        </div>

        <!-- Register Form -->
        <div style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: var(--spacing-lg); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);">
            <!-- Error Messages -->
            @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: var(--spacing-sm); border-radius: 8px; margin-bottom: var(--spacing-md); font-size: 0.9rem;">
                <ul style="margin: 0; padding-left: var(--spacing-sm);">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('auth.register') }}">
                @csrf

                <!-- Full Name -->
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Họ và tên</label>
                    <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                </div>

                <!-- Username -->
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Tên đăng nhập</label>
                    <input type="text" name="username" value="{{ old('username') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                    <p style="color: rgba(255,255,255,0.5); font-size: 0.85rem; margin-top: 4px;">Tối thiểu 3 ký tự</p>
                </div>

                <!-- Email -->
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                </div>

                <!-- Password -->
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Mật khẩu</label>
                    <input type="password" name="password" required style="width: 100%; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                    <p style="color: rgba(255,255,255,0.5); font-size: 0.85rem; margin-top: 4px;">Tối thiểu 6 ký tự</p>
                </div>

                <!-- Confirm Password -->
                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" required style="width: 100%; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                </div>

                <!-- Submit Button -->
                <button type="submit" style="width: 100%; padding: 12px; background: var(--color-secondary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 1rem;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(212,175,55,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    Đăng Ký
                </button>

                <!-- Divider -->
                <div style="margin: var(--spacing-lg) 0; display: flex; align-items: center; gap: var(--spacing-md);">
                    <div style="flex: 1; height: 1px; background: rgba(255,255,255,0.1);"></div>
                    <span style="color: rgba(255,255,255,0.6); font-size: 0.9rem;">Hoặc</span>
                    <div style="flex: 1; height: 1px; background: rgba(255,255,255,0.1);"></div>
                </div>

                <!-- Google Login Button -->
                <a href="{{ route('auth.google') }}" style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 12px 16px; background: white; color: #1f2937; border: none; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; text-decoration: none; transition: all 0.3s ease; gap: 8px;" onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0,0,0,0.2)'" onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g transform="matrix(1, 0, 0, 1, 27.009766, -39.238281)">
                            <path fill="#4285F4" d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z"/>
                            <path fill="#34A853" d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z"/>
                            <path fill="#FBBC05" d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z"/>
                            <path fill="#EA4335" d="M -14.754 43.989 C -13.004 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z"/>
                        </g>
                    </svg>
                    Đăng ký với Google
                </a>
            </form>

            <!-- Login Link -->
            <div style="text-align: center; margin-top: var(--spacing-md);">
                <p style="color: rgba(255,255,255,0.6); margin: 0;">Đã có tài khoản? 
                    <a href="{{ route('login') }}" style="color: var(--color-secondary); text-decoration: none; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
