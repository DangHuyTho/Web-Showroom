<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerificationController extends Controller
{
    /**
     * Show pending staff/admin registration requests
     */
    public function index(Request $request)
    {
        $query = EmailVerification::where('is_admin_verification', true)
                                   ->orderBy('created_at', 'desc');

        if ($request->has('status')) {
            if ($request->status === 'expired') {
                $query->where('expires_at', '<', now());
            } elseif ($request->status === 'active') {
                $query->where('expires_at', '>=', now());
            }
        }

        $requests = $query->paginate(15);

        return view('admin.verifications.index', compact('requests'));
    }

    /**
     * Show verification details
     */
    public function show(EmailVerification $verification)
    {
        // Check if already used
        $existingUser = User::where('email', $verification->email)->first();
        if ($existingUser) {
            return redirect()->route('admin.verifications.index')
                           ->with('error', 'Tài khoản này đã được tạo.');
        }

        return view('admin.verifications.show', compact('verification'));
    }

    /**
     * Approve verification and create user
     */
    public function approve(Request $request, EmailVerification $verification)
    {
        // Check if verification is expired
        if ($verification->isExpired()) {
            $verification->delete();
            return back()->with('error', 'Yêu cầu đã hết hạn.');
        }

        // Check if user already exists
        if (User::where('email', $verification->email)->exists()) {
            $verification->delete();
            return back()->with('error', 'Email này đã được sử dụng.');
        }

        // Create user
        $user = User::create([
            'name' => $verification->name,
            'username' => $verification->username,
            'email' => $verification->email,
            'password' => $verification->password_hash,
            'role' => $this->determineRole($verification->username),
            'is_active' => true,
            'password_set' => true,
        ]);

        // Create cart for user if regular user
        if ($user->role === 'user') {
            Cart::create(['user_id' => $user->id]);
        }

        // Delete verification record
        $verification->delete();

        return redirect()->route('admin.verifications.index')
                       ->with('success', "Tài khoản {$verification->username} đã được phê duyệt thành công!");
    }

    /**
     * Reject verification request
     */
    public function reject(Request $request, EmailVerification $verification)
    {
        $username = $verification->username;
        
        // Delete verification record
        $verification->delete();

        return redirect()->route('admin.verifications.index')
                       ->with('success', "Yêu cầu đăng ký {$username} đã bị từ chối.");
    }

    /**
     * Resend OTP to admin
     */
    public function resendOtp(Request $request, EmailVerification $verification)
    {
        // Generate new OTP
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Update verification record
        $verification->update([
            'otp' => $otp,
            'attempts' => 0,
            'expires_at' => now()->addMinutes(15),
        ]);

        return back()->with('success', "OTP mới: {$otp} (Hiệu lực trong 15 phút)");
    }

    /**
     * Determine role based on username
     */
    private function determineRole($username)
    {
        if (str_ends_with($username, '.admin')) {
            return 'admin';
        } elseif (str_ends_with($username, '.staff')) {
            return 'staff';
        }
        return 'user';
    }
}
