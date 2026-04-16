<!-- Password Setup Modal -->
@if (Auth::check() && !Auth::user()->password_set)
<div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; z-index: 9999;">
    <div style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); max-width: 450px; width: 90%;">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="font-size: 1.5rem; color: var(--color-primary); margin: 0 0 10px 0; font-weight: 700;">🔐 Đặt Mật Khẩu</h2>
            <p style="color: #6b7280; font-size: 0.95rem; margin: 0;">
                Đăng nhập Google thành công! Vui lòng đặt mật khẩu để có thể đăng nhập bằng email + mật khẩu lần tiếp theo.
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('password.setup') }}" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf
            
            <!-- Username Display -->
            <div>
                <label style="display: block; color: var(--color-primary); margin-bottom: 8px; font-weight: 600; font-size: 0.95rem;">Tên đăng nhập (Email)</label>
                <input type="text" value="{{ Auth::user()->username }}" disabled
                    style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 1rem; box-sizing: border-box; background: #f9fafb; color: #6b7280;">
                <p style="color: #6b7280; font-size: 0.85rem; margin: 5px 0 0 0;">Tên đăng nhập không thể thay đổi</p>
            </div>

            <!-- Password -->
            <div>
                <label style="display: block; color: var(--color-primary); margin-bottom: 8px; font-weight: 600; font-size: 0.95rem;">Mật khẩu mới</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu (ít nhất 6 ký tự)"
                    style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease;"
                    onfocus="this.style.borderColor='var(--color-secondary)'"
                    onblur="this.style.borderColor='#e5e7eb'"
                    required>
                @error('password')
                <span style="color: #dc2626; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label style="display: block; color: var(--color-primary); margin-bottom: 8px; font-weight: 600; font-size: 0.95rem;">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu"
                    style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease;"
                    onfocus="this.style.borderColor='var(--color-secondary)'"
                    onblur="this.style.borderColor='#e5e7eb'"
                    required>
                @error('password_confirmation')
                <span style="color: #dc2626; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Info Box -->
            <div style="background: #fef3c7; padding: 12px; border-radius: 8px; border-left: 4px solid #fbbf24;">
                <p style="color: #92400e; font-size: 0.85rem; margin: 0; line-height: 1.5;">
                    <strong>✓ Lợi ích:</strong> Lần sau bạn có thể đăng nhập bằng email <strong>{{ Auth::user()->username }}</strong> + mật khẩu này, không cần qua Google.
                </p>
            </div>

            <!-- Buttons Container -->
            <div style="display: flex; gap: 12px; flex-direction: column;">
                <!-- Submit Button -->
                <button type="submit" 
                    style="width: 100%; padding: 12px 20px; background: var(--color-secondary); color: var(--color-primary); border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 1rem;"
                    onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'"
                    onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                    Đặt Mật Khẩu & Tiếp Tục
                </button>
            </div>
        </form>

        <!-- Logout Button - Outside Form -->
        <div style="margin-top: 15px; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 15px;">
            <p style="color: #6b7280; font-size: 0.85rem; margin: 0 0 12px 0;">
                Hoặc nếu không muốn đặt mật khẩu ngay:
            </p>
            <form method="POST" action="{{ route('logout') }}" style="display: inline-block; width: 100%;">
                @csrf
                <button type="submit" 
                    style="width: 100%; padding: 10px 20px; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 0.95rem;"
                    onmouseover="this.style.background='#fecaca'; this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.background='#fee2e2'; this.style.transform='translateY(0)'">
                    🚪 Đăng Xuất
                </button>
            </form>
        </div>
    </div>
</div>
@endif
