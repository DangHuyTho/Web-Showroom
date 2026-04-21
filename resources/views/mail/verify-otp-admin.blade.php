<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        a {
            color: #d4af37;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333;">
    <div style="background: linear-gradient(135deg, #d4af37 0%, #a68c45 100%); padding: 30px; text-align: center; border-radius: 8px 8px 0 0;">
        <h1 style="margin: 0; color: white; font-size: 28px;">🔐 Xác Thực Tài Khoản Nhân Viên</h1>
    </div>

    <div style="background: #f9f9f9; padding: 30px; border: 1px solid #ddd; border-top: none;">
        <p style="margin-top: 0; color: #333; font-size: 16px;">
            Chào Admin,
        </p>

        <p style="color: #555; font-size: 15px; line-height: 1.6;">
            Có một yêu cầu đăng ký tài khoản nhân viên cần được xác thực:
        </p>

        <div style="background: white; border-left: 4px solid #d4af37; padding: 20px; margin: 20px 0; border-radius: 4px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; width: 150px; color: #666; font-weight: 600;">📝 Tên Đăng Nhập:</td>
                    <td style="padding: 8px 0; color: #333; font-size: 16px; font-weight: 700;">{{ $username }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: 600;">👤 Tên Người Dùng:</td>
                    <td style="padding: 8px 0; color: #333;">{{ $name }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: 600;">📧 Email:</td>
                    <td style="padding: 8px 0; color: #333;">{{ $email }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: 600;">🏷️ Vai Trò Yêu Cầu:</td>
                    <td style="padding: 8px 0; color: #d4af37; font-weight: 700; font-size: 16px;">
                        @if(strpos($requestedRole, 'admin') !== false)
                            👨‍💼 QUẢN TRỊ VIÊN
                        @elseif(strpos($requestedRole, 'staff') !== false)
                            👨‍💼 NHÂN VIÊN
                        @else
                            {{ strtoupper($requestedRole) }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 4px;">
            <p style="margin: 0; color: #856404; font-weight: 600;">
                ⚠️ Yêu cầu xác thực nhân viên
            </p>
            <p style="margin: 10px 0 0 0; color: #856404; font-size: 14px;">
                Chỉ những yêu cầu được phê duyệt mới có thể hoàn tất đăng ký. Cung cấp mã OTP dưới đây cho nhân viên sau khi xác minh thông tin.
            </p>
        </div>

        <p style="color: #666; font-size: 15px; margin: 20px 0 10px 0;">
            <strong>Mã Xác Thực OTP:</strong>
        </p>

        <div style="background: #1a1a1a; color: #d4af37; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 0; font-size: 14px; color: rgba(255,255,255,0.7);">Cung cấp mã này cho nhân viên:</p>
            <p style="margin: 15px 0 0 0; font-size: 36px; font-weight: 700; font-family: 'Courier New', monospace; letter-spacing: 6px;">
                {{ $otp }}
            </p>
        </div>

        <div style="background: #e8f4f8; border-left: 4px solid #17a2b8; padding: 15px; margin: 20px 0; border-radius: 4px;">
            <p style="margin: 0 0 8px 0; color: #17a2b8; font-weight: 600;">ℹ️ Hướng Dẫn:</p>
            <ul style="margin: 8px 0 0 0; padding-left: 20px; color: #555; font-size: 14px;">
                <li>Mã này có hiệu lực trong <strong>15 phút</strong></li>
                <li>Cung cấp mã cho nhân viên qua kênh an toàn (không qua email)</li>
                <li>Nhân viên sẽ nhập mã này để hoàn tất đăng ký</li>
                <li>Chỉ 5 lần thử nhập sai được cho phép</li>
            </ul>
        </div>

        <p style="color: #999; font-size: 13px; margin-top: 30px; border-top: 1px solid #ddd; padding-top: 20px;">
            Đây là email tự động từ hệ thống Showroom Hộ Nhân. Vui lòng không trả lời email này.
        </p>
    </div>

    <div style="background: #f0f0f0; padding: 20px; text-align: center; border-radius: 0 0 8px 8px; color: #999; font-size: 12px;">
        <p style="margin: 0;">© 2026 Showroom Hộ Nhân. All rights reserved.</p>
    </div>
</div>

</body>
</html>
