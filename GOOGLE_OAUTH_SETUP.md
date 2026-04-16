# Google OAuth Setup Guide

## Overview

This guide explains how to set up and use Google OAuth authentication in your Laravel e-commerce application. Users can now log in or register using their Google account, with their role automatically set to 'user' as per system requirements.

## Features

- ✅ **Google Login**: Users can sign in with their Google account
- ✅ **Google Registration**: Users can quickly create an account with Google
- ✅ **Automatic Cart Creation**: A shopping cart is automatically created for new Google users
- ✅ **Pattern-Based Roles**: Username patterns determine user roles:
  - Usernames ending in `.admin` → Admin role
  - Usernames ending in `.staff` → Staff role
  - All other usernames → User role
- ✅ **Gmail Users Are Regular Users**: All users registering via Gmail automatically get the 'user' role

## Prerequisites

1. **Laravel Socialite** - Already installed (v5.25.0)
2. **Google Cloud Project** - You need to create one
3. **Google OAuth 2.0 Credentials** - Client ID and Client Secret

## Step 1: Create a Google Cloud Project

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project:
   - Click "Select a Project" → "NEW PROJECT"
   - Enter project name (e.g., "E-commerce Store")
   - Click "CREATE"
3. Enable the Google+ API:
   - Search for "Google+ API" in the search bar
   - Click it and select "ENABLE"

## Step 2: Create OAuth 2.0 Credentials

1. Go to **Credentials** (left sidebar)
2. Click **"Create Credentials"** → **"OAuth client ID"**
3. You may be prompted to create a consent screen first:
   - Choose "External" user type
   - Fill in the required fields (app name, user support email, etc.)
   - Save and continue
4. Back to OAuth client creation:
   - Select **"Web application"**
   - Give it a name (e.g., "E-commerce Web App")
   - Under "Authorized redirect URIs", add:
     ```
     http://localhost:8000/auth/google/callback
     http://yourdomain.com/auth/google/callback
     ```
   - Click "CREATE"
5. Copy your **Client ID** and **Client Secret** from the dialog

## Step 3: Configure Environment Variables

1. Open `.env` file in your project root
2. Add these lines:
   ```env
   GOOGLE_CLIENT_ID=your_client_id_here
   GOOGLE_CLIENT_SECRET=your_client_secret_here
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```
3. Replace values with your actual credentials from Step 2

## Step 4: Verify Configuration

The configuration is already in place:

```php
// config/services.php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI', '/auth/google/callback'),
]
```

## How It Works

### Login Flow

1. User visits login page and clicks **"Đăng nhập với Google"**
2. Redirected to Google login page
3. User authenticates with Google
4. Callback received at `/auth/google/callback`
5. AuthController checks if user exists:
   - **If exists by google_id**: Updates token and logs in
   - **If email exists but no google_id**: Links Google to existing account
   - **If new user**: Creates new user with role='user', generates unique username
6. Cart automatically created for new users
7. User logged in and redirected to home page

### Registration Flow

1. User can click **"Đăng ký với Google"** on registration page
2. Same Google authentication flow as login
3. New user created with role='user'
4. Cart automatically created
5. User logged in and redirected to home page

### Role Assignment

**At Registration/Login:**
- Username with `.admin` suffix → role='admin'
- Username with `.staff` suffix → role='staff'
- Other usernames → role='user'

**For Google Users:**
- Always get role='user' initially
- Generated username from email (e.g., "john_doe" from john.doe@gmail.com)
- If username conflicts, counter added (e.g., "john_doe1", "john_doe2")

**Role Validation:**
- Every time user logs in (traditional or OAuth), role is validated against username pattern
- If mismatch found, role is automatically updated

## Implementation Details

### Key Methods in AuthController

```php
// Determines role based on username pattern
private function determineRoleByUsername($username)
{
    if (str_ends_with($username, '.admin')) {
        return 'admin';
    } elseif (str_ends_with($username, '.staff')) {
        return 'staff';
    }
    return 'user';
}

// Redirects to Google login
public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

// Handles Google callback
public function handleGoogleCallback()
{
    // Gets Google user data
    // Creates or updates user
    // Creates cart for new users
    // Logs user in
}
```

### Database Fields

The User model has these OAuth-related fields:
- `google_id` - Google's unique user identifier
- `google_token` - OAuth token for future API access (if needed)
- `role` - User's role (user, staff, admin)
- `is_active` - Whether account is active

## Testing

### Local Testing

1. Make sure `.env` has test credentials
2. For local development, Google allows `http://localhost:8000` and similar
3. Visit `http://localhost:8000/login`
4. Click "Đăng nhập với Google"
5. Authenticate with your Google account
6. You should be logged in and redirected

### Testing Role Pattern Recognition

1. Register traditional account with username `testuser.admin`
2. Your role should be 'admin'
3. Visit `/admin/dashboard` - should work
4. Try `testuser.staff` - should be staff
5. Google users always get 'user' role

## Troubleshooting

### "Invalid Client" Error
- Verify Client ID and Client Secret are correct in `.env`
- Check they match what's in Google Cloud Console

### "Redirect URI Mismatch"
- Ensure GOOGLE_REDIRECT_URI in `.env` exactly matches what's set in Google Cloud Console
- Include the full URL including protocol (http/https)

### User Not Created
- Check database user can be created (no constraints preventing it)
- Ensure Cart table exists (migration should have created it)
- Check application logs for errors

### Password Reset for Google Users
- Google users have random passwords generated
- They don't need password reset - just use "Sign in with Google"
- If needed, can still reset via traditional password reset form

## Security Notes

1. **Token Storage**: Google tokens are stored in database for potential future API use
2. **Random Passwords**: Google users get random secure passwords they never know
3. **Active Check**: System validates users are active before login
4. **Email Verification**: Consider adding email verification for new accounts
5. **HTTPS in Production**: Always use HTTPS in production (Google requires it)

## Feature Limitations & Future Enhancements

### Current Limitations
- Still uses HTTP for local development
- Credit card and e-wallet placeholders not implemented
- No email notifications yet

### Potential Enhancements
1. **Multiple Providers**: Add Facebook, GitHub, Microsoft login
2. **Profile Picture**: Fetch and store user's Google profile picture
3. **Auto-Login**: Remember device and auto-login next time
4. **Refresh Token**: Implement token refresh for long sessions
5. **Scopes**: Request additional scopes (calendar, Gmail, etc.) if needed

## Default Routes Created

- `GET /auth/google` - Redirects to Google login
- `GET /auth/google/callback` - Handles Google callback
- Both routes are **public** (no authentication required)

## Files Modified

1. **app/Http/Controllers/AuthController.php**
   - Added `redirectToGoogle()` method
   - Added `handleGoogleCallback()` method
   - Enhanced `login()` to validate roles against username patterns

2. **routes/web.php**
   - Added two new public routes for Google OAuth

3. **resources/views/auth/login.blade.php**
   - Added "Đăng nhập với Google" button
   - Added divider between traditional and OAuth login

4. **resources/views/auth/register.blade.php**
   - Added "Đăng ký với Google" button
   - Allows quick registration without filling form

## Configuration Already Done

✅ config/services.php - Google OAuth configuration
✅ app/Http/Controllers/AuthController.php - OAuth implementation
✅ routes/web.php - OAuth routes
✅ views - Login/Register buttons added
✅ Laravel Socialite - Package installed

## Next Steps

1. **Get Google Credentials**: Follow steps 1-2 above
2. **Update .env**: Add your credentials
3. **Test**: Try logging in with Google
4. **Monitor**: Check logs for any issues
5. **Optional**: Set up email notifications for new accounts

## Support & Documentation

- [Laravel Socialite Docs](https://laravel.com/docs/11.x/socialite)
- [Google OAuth Docs](https://developers.google.com/identity/protocols/oauth2)
- [Google Cloud Console](https://console.cloud.google.com/)

---

**Last Updated**: 2024
**Laravel Version**: 11.x
**Socialite Version**: 5.25.0
