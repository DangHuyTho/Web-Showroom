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
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
        }
        .header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .content p {
            margin: 10px 0;
        }
        .otp-box {
            background: #f0f0f0;
            border: 2px solid #d4af37;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #d4af37;
            letter-spacing: 5px;
            font-family: monospace;
        }
        .warning {
            background: #ffe6e6;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin: 15px 0;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #d4af37;
            color: #1a1a1a;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Showroom Hộ Nhân</h1>
            <p>Xác Thực Đăng Ký Tài Khoản</p>
        </div>

        <div class="content">
            <p>Xin chào {{ $name }},</p>

            <p>Cảm ơn bạn đã đăng ký tài khoản trên Showroom Hộ Nhân. Để hoàn tất quy trình đăng ký, vui lòng xác thực email của bạn bằng mã OTP dưới đây.</p>

            <div class="otp-box">
                <p style="margin: 0 0 10px 0; color: #666;">Mã xác thực của bạn:</p>
                <div class="otp-code">{{ $otp }}</div>
                <p style="margin: 10px 0 0 0; color: #999; font-size: 12px;">Mã này có hiệu lực trong 15 phút</p>
            </div>

            <div class="warning">
                <strong>⚠️ Lưu ý quan trọng:</strong> Vui lòng không chia sẻ mã OTP này với bất kỳ ai. Chúng tôi sẽ không bao giờ yêu cầu mã OTP qua email.
            </div>

            <p><strong>Email của bạn:</strong> {{ $email }}</p>

            <p>Nếu bạn không tạo tài khoản này, vui lòng bỏ qua email này.</p>
        </div>

        <div class="footer">
            <p>© 2026 Showroom Hộ Nhân. Tất cả quyền được bảo lưu.</p>
            <p>Đây là email tự động, vui lòng không trả lời.</p>
        </div>
    </div>
</body>
</html>
