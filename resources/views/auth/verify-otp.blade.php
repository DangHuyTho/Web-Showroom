@extends('layouts.app')

@section('title', 'Xác Thực Email')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <div style="width: 100%; max-width: 500px; padding: var(--spacing-md);">
        <!-- Logo -->
        <div style="text-align: center; margin-bottom: var(--spacing-lg);">
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--color-secondary); font-family: 'Playfair Display', serif;">Xác Thực Email</h1>
        </div>

        <!-- Verification Form -->
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

            <!-- Instructions -->
            <div style="background: rgba(212, 175, 55, 0.1); border-left: 4px solid var(--color-secondary); padding: var(--spacing-md); border-radius: 6px; margin-bottom: var(--spacing-lg);">
                @if($isAdminVerification ?? false)
                    <p style="margin: 0; color: rgba(255,255,255,0.9); font-size: 0.95rem;">
                        📧 Yêu cầu đăng ký tài khoản nhân viên đã được gửi tới quản trị viên.
                    </p>
                    <p style="margin: 8px 0 0 0; color: var(--color-secondary); font-weight: 600; font-size: 0.95rem;">
                        Admin sẽ gửi mã xác thực cho bạn qua kênh an toàn (không phải email).
                    </p>
                    <p style="margin: 8px 0 0 0; color: rgba(255,255,255,0.7); font-size: 0.85rem;">
                        Vui lòng nhập mã xác thực 6 chữ số được admin cung cấp. Mã này có hiệu lực trong 15 phút.
                    </p>
                @else
                    <p style="margin: 0; color: rgba(255,255,255,0.9); font-size: 0.95rem;">
                        Chúng tôi đã gửi mã xác thực 6 chữ số đến email:
                    </p>
                    <p style="margin: 8px 0 0 0; color: var(--color-secondary); font-weight: 600; font-size: 0.95rem;">
                        {{ $email ?? 'Email của bạn' }}
                    </p>
                    <p style="margin: 8px 0 0 0; color: rgba(255,255,255,0.7); font-size: 0.85rem;">
                        Vui lòng nhập mã xác thực dưới đây. Mã này có hiệu lực trong 15 phút.
                    </p>
                @endif
            </div>

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

            <form method="POST" action="{{ route('auth.verify-otp') }}">
                @csrf

                <!-- Email (Hidden) -->
                <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                <!-- OTP Input -->
                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-xs); font-weight: 500;">Mã xác thực (6 chữ số)</label>
                    <input 
                        type="text" 
                        name="otp" 
                        value="{{ old('otp') }}" 
                        maxlength="6"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        placeholder="000000"
                        required 
                        style="width: 100%; padding: 12px 16px; border: 2px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; font-size: 1.5rem; text-align: center; letter-spacing: 8px; font-weight: 600; transition: all 0.3s ease; font-family: monospace;" 
                        onfocus="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" 
                        onblur="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'"
                    >
                    @if($errors->has('otp'))
                    <p style="color: #fee2e2; font-size: 0.85rem; margin-top: 4px;">{{ $errors->first('otp') }}</p>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" style="width: 100%; padding: 12px 16px; background: var(--color-secondary); color: var(--color-primary); border: none; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease; margin-bottom: var(--spacing-md);" onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(212,175,55,0.3)'" onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    Xác Thực
                </button>
            </form>

            <!-- Resend OTP Form -->
            <div style="text-align: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: var(--spacing-md);">
                <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem; margin-bottom: var(--spacing-sm);">Không nhận được mã?</p>
                <form method="POST" action="{{ route('auth.resend-otp') }}" style="display: inline;">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                    <button type="submit" style="background: transparent; color: var(--color-secondary); border: none; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease; text-decoration: underline;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                        Gửi lại mã xác thực
                    </button>
                </form>
            </div>

            <!-- Back to Login -->
            <div style="text-align: center; margin-top: var(--spacing-lg);">
                <a href="{{ route('login') }}" style="color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.color='var(--color-secondary)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">← Quay lại đăng nhập</a>
            </div>
        </div>

        <!-- Security Info -->
        <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 8px; padding: var(--spacing-md); margin-top: var(--spacing-lg); text-align: center;">
            <p style="color: rgba(255,255,255,0.6); font-size: 0.85rem; margin: 0;">
                🔒 Thông tin của bạn được bảo mật 100%. Chúng tôi sẽ không bao giờ yêu cầu mã OTP qua điện thoại hoặc tin nhắn.
            </p>
        </div>
    </div>
</div>

<script>
    // Auto-focus on next field when 6 digits entered
    document.addEventListener('DOMContentLoaded', function() {
        const otpInput = document.querySelector('input[name="otp"]');
        if (otpInput) {
            otpInput.addEventListener('input', function(e) {
                // Remove non-digits
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Auto-submit when 6 digits entered
                if (this.value.length === 6) {
                    // Optional: auto-submit after a short delay
                    // this.form.submit();
                }
            });
        }
    });
</script>
@endsection
