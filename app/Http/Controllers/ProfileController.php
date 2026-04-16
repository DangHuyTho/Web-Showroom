<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show user profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required' => 'Vui lòng nhập tên',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',
                'email.unique' => 'Email này đã được sử dụng',
                'avatar.image' => 'File phải là ảnh',
                'avatar.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif',
                'avatar.max' => 'Ảnh không được vượt quá 2MB',
            ]);

            // Update basic info
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists and is not Google avatar
                if ($user->avatar_url && !str_contains($user->avatar_url, 'lh3.googleusercontent.com') && !str_contains($user->avatar_url, 'ui-avatars.com')) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $user->avatar_url));
                }

                // Store new avatar
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->update([
                    'avatar_url' => '/storage/' . $path,
                ]);
            }

            // Refresh user in session to reflect changes - CRITICAL
            $user = $user->fresh();
            Auth::setUser($user);

            return redirect()->route('profile.edit')->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Setup password for Google users
     */
    public function setupPassword(Request $request)
    {
        $user = Auth::user();

        // Check if user already set password
        if ($user->password_set) {
            return redirect()->route('home')->with('error', 'Bạn đã đặt mật khẩu rồi');
        }

        // Validate password
        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp',
        ]);

        // Update user password
        $user->update([
            'password' => Hash::make($validated['password']),
            'password_set' => true,
        ]);

        // Refresh user in session
        $user = $user->fresh();
        Auth::setUser($user);

        return redirect()->route('home')->with('success', 'Mật khẩu đã được đặt thành công! Lần tiếp theo bạn có thể đăng nhập bằng email và mật khẩu này.');
    }
}
