<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');
        }

        return back()->with('error', 'Tên đăng nhập hoặc mật khẩu không chính xác')->onlyInput('username');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Đã đăng xuất!');
    }

    /**
     * Show change password form
     */
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    /**
     * Handle password change
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không chính xác');
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|exists:users,username',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'username.exists' => 'Tên đăng nhập không tồn tại',
        ]);

        $user = User::where('username', $validated['username'])->first();
        
        // Generate random 6-digit token
        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Save token to database
        DB::table('password_resets')->updateOrInsert(
            ['username' => $user->username],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );

        // Send email with token
        $email = '21012521@st.phenikaa-uni.edu.vn';
        $mailSubject = 'Mã xác nhận đặt lại mật khẩu - Admin Showroom';
        $mailMessage = "Mã xác nhận đặt lại mật khẩu: {$token}\n\nHãy nhập mã này để tiến hành đặt lại mật khẩu của bạn.\n\nMã này sẽ hết hạn sau 24 giờ.";
        
        try {
            Mail::raw($mailMessage, function ($message) use ($email, $mailSubject) {
                $message->to($email)->subject($mailSubject);
            });
            return redirect()->route('auth.verify-reset-token')->with('success', 'Mã xác nhận đã được gửi tới email! Vui lòng kiểm tra.')
                ->with('username', $user->username);
        } catch (\Exception $e) {
            // Fallback: show error but still proceed (for development)
            \Log::error('Failed to send reset email: ' . $e->getMessage());
            return redirect()->route('auth.verify-reset-token')
                ->with('info', 'Mã xác nhận đã được tạo. Vui lòng kiểm tra email của bạn.')
                ->with('username', $user->username);
        }
    }

    /**
     * Show verify reset token form
     */
    public function showVerifyResetToken()
    {
        $username = session('username');
        if (!$username) {
            return redirect()->route('auth.forgot-password')->with('error', 'Vui lòng yêu cầu mã xác nhận trước.');
        }
        return view('auth.verify-reset-token', compact('username'));
    }

    /**
     * Verify reset token and show password form
     */
    public function verifyResetToken(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|exists:users,username',
            'token' => 'required|string|size:6',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'username.exists' => 'Tên đăng nhập không tồn tại',
            'token.required' => 'Vui lòng nhập mã xác nhận',
            'token.size' => 'Mã xác nhận phải có 6 chữ số',
        ]);

        $reset = DB::table('password_resets')
                    ->where('username', $validated['username'])
                    ->first();

        if (!$reset) {
            return back()->with('error', 'Mã xác nhận không tồn tại. Vui lòng yêu cầu lại.');
        }

        if ($reset->token !== $validated['token']) {
            return back()->with('error', 'Mã xác nhận không chính xác.');
        }

        // Check if token is expired (24 hours)
        if (now()->diffInHours($reset->created_at) > 24) {
            DB::table('password_resets')->where('username', $validated['username'])->delete();
            return back()->with('error', 'Mã xác nhận đã hết hạn. Vui lòng yêu cầu lại.');
        }

        // Token is valid, show password reset form
        return redirect()->route('auth.reset-password-form')->with('username', $validated['username']);
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm()
    {
        $username = session('username');
        if (!$username) {
            return redirect()->route('auth.forgot-password')->with('error', 'Phiên hết hạn. Vui lòng yêu cầu mã xác nhận lại.');
        }
        return view('auth.reset-password', compact('username'));
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|exists:users,username',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'username.exists' => 'Tên đăng nhập không tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp',
        ]);

        $user = User::where('username', $validated['username'])->first();
        
        // Update password
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Delete reset token
        DB::table('password_resets')->where('username', $validated['username'])->delete();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được đặt lại thành công! Vui lòng đăng nhập.');
    }
}
