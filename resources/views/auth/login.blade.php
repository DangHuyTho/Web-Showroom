@extends('layouts.app')

@section('title', 'Đăng Nhập Admin')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <div style="width: 100%; max-width: 400px; padding: var(--spacing-md);">
        <!-- Logo -->
        <div style="text-align: center; margin-bottom: var(--spacing-lg);">
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--color-secondary); font-family: 'Playfair Display', serif;">Đăng Nhập</h1>
        </div>

        <!-- Tab Buttons -->
        <div style="display: flex; gap: var(--spacing-md); margin-bottom: var(--spacing-lg); border-bottom: 2px solid rgba(255, 255, 255, 0.1);">
            <button id="loginTab" type="button" onclick="switchTab('login')" style="flex: 1; padding: 12px 16px; background: transparent; color: var(--color-secondary); border: none; border-bottom: 3px solid var(--color-secondary); font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 0.95rem;">Đăng Nhập</button>
            <button id="registerTab" type="button" onclick="switchTab('register')" style="flex: 1; padding: 12px 16px; background: transparent; color: rgba(255,255,255,0.5); border: none; border-bottom: 3px solid transparent; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 0.95rem;">Đăng Ký</button>
        </div>

        <!-- Login Form -->
        <div id="loginForm" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: var(--spacing-lg); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);">
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

                <!-- Divider -->
                <div style="margin: var(--spacing-md) 0; display: flex; align-items: center; gap: var(--spacing-md);">
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
                    Đăng nhập với Google
                </a>
            </form>
        </div>

        <!-- Register Form -->
        <div id="registerForm" style="display: none; background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: var(--spacing-lg); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);">
            <!-- Info Message -->
            <div style="background: rgba(212, 175, 55, 0.1); border-left: 4px solid var(--color-secondary); padding: var(--spacing-md); border-radius: 6px; margin-bottom: var(--spacing-lg);">
                <p style="margin: 0; color: rgba(255,255,255,0.9); font-size: 0.9rem;">
                    ℹ️ Sau khi đăng ký, chúng tôi sẽ gửi mã xác thực 6 chữ số đến email của bạn. Vui lòng kiểm tra inbox hoặc spam folder.
                </p>
            </div>

            <!-- Register Errors -->
            @if ($errors->any() && old('register'))
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
                    @if($errors->has('name'))
                    <p style="color: #fee2e2; font-size: 0.85rem; margin-top: 4px;">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                <!-- Email -->
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                    @if($errors->has('email'))
                    <p style="color: #fee2e2; font-size: 0.85rem; margin-top: 4px;">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <!-- Username -->
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Tên đăng nhập</label>
                    <input type="text" name="username" value="{{ old('username') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                    @if($errors->has('username'))
                    <p style="color: #fee2e2; font-size: 0.85rem; margin-top: 4px;">{{ $errors->first('username') }}</p>
                    @endif
                </div>

                <!-- Password -->
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Mật khẩu</label>
                    <input type="password" name="password" required style="width: 100%; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                    @if($errors->has('password'))
                    <p style="color: #fee2e2; font-size: 0.85rem; margin-top: 4px;">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" required style="width: 100%; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                </div>

                <!-- Submit Button -->
                <button type="submit" style="width: 100%; padding: 12px 16px; background: var(--color-secondary); color: var(--color-primary); border: none; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(212,175,55,0.3)'" onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    Đăng Ký
                </button>

                <!-- Divider -->
                <div style="margin: var(--spacing-md) 0; display: flex; align-items: center; gap: var(--spacing-md);">
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
                    Đăng nhập với Google
                </a>
            </form>
        </div>

        <!-- Back Link -->
        <div style="text-align: center; margin-top: var(--spacing-lg);">
            <a href="{{ url('/') }}" style="color: var(--color-secondary); text-decoration: none; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">← Quay lại trang chủ</a>
        </div>
    </div>
</div>

<script>
    function switchTab(tab) {
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');

        if (tab === 'login') {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
            loginTab.style.borderBottom = '3px solid var(--color-secondary)';
            loginTab.style.color = 'var(--color-secondary)';
            registerTab.style.borderBottom = '3px solid transparent';
            registerTab.style.color = 'rgba(255,255,255,0.5)';
        } else {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
            loginTab.style.borderBottom = '3px solid transparent';
            loginTab.style.color = 'rgba(255,255,255,0.5)';
            registerTab.style.borderBottom = '3px solid var(--color-secondary)';
            registerTab.style.color = 'var(--color-secondary)';
        }
    }

    // Check if we should show register form on page load
    window.addEventListener('load', function() {
        const url = new URL(window.location);
        if (url.searchParams.get('tab') === 'register') {
            switchTab('register');
        }
    });
</script>
@endsection
