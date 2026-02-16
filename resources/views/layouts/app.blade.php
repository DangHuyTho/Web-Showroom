<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hộ Nhâm - Showroom Vật Liệu Xây Dựng Cao Cấp')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="shortcut icon" type="image/png" href="/images/logo.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --color-primary: #1a1a1a;
            --color-secondary: #d4af37;
            --color-accent: #f5f5f0;
            --color-text: #2c2c2c;
            --color-text-light: #6b6b6b;
            --color-border: #e5e5e5;
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 2rem;
            --spacing-lg: 4rem;
            --spacing-xl: 6rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--color-text);
            background-color: #ffffff;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 var(--spacing-md);
        }

        /* Header */
        header {
            background: #ffffff;
            border-bottom: 1px solid var(--color-border);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--spacing-sm) var(--spacing-md);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .logo img {
            height: 40px;
            width: auto;
        }

        .nav-links {
            display: flex;
            gap: var(--spacing-md);
            list-style: none;
        }

        .nav-links a {
            color: var(--color-text);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--color-secondary);
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 80vh;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #808080;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 500;
        }

        /* Section */
        .section {
            padding: var(--spacing-xl) 0;
        }

        .section-title {
            font-size: 2.5rem;
            margin-bottom: var(--spacing-md);
            text-align: center;
            color: var(--color-primary);
        }

        .section-subtitle {
            text-align: center;
            color: var(--color-text-light);
            margin-bottom: var(--spacing-lg);
            font-size: 1.1rem;
        }

        /* Grid */
        .grid {
            display: grid;
            gap: var(--spacing-md);
        }

        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        .grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        /* Card */
        .card {
            background: #ffffff;
            border: 1px solid var(--color-border);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-image {
            width: 100%;
            height: 300px;
            background: #808080;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .card-body {
            padding: var(--spacing-md);
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: var(--spacing-xs);
            color: var(--color-primary);
        }

        .card-text {
            color: var(--color-text-light);
            font-size: 0.95rem;
        }

        /* Button */
        .btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: var(--color-primary);
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s ease;
            text-align: center;
        }

        .btn:hover {
            background: var(--color-secondary);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
        }

        .btn-secondary:hover {
            background: var(--color-primary);
            color: white;
        }

        /* Footer */
        footer {
            background: var(--color-primary);
            color: white;
            padding: var(--spacing-lg) 0;
            margin-top: var(--spacing-xl);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-md);
        }

        .footer-section h3 {
            margin-bottom: var(--spacing-sm);
            font-size: 1.25rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: var(--spacing-xs);
        }

        .footer-section a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--color-secondary);
        }

        /* Placeholder Image */
        .placeholder-image {
            background: #808080;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
            text-align: center;
            padding: 2rem;
        }

        /* Brand Logo */
        .brand-logo {
            width: 150px;
            height: 80px;
            background: #808080;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin: 0 auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                gap: var(--spacing-xs);
            }

            .hero {
                height: 60vh;
                min-height: 400px;
            }

            .section-title {
                font-size: 2rem;
            }

            .grid-4 {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="container">
            <a href="{{ route('home') }}" class="logo">
                <img src="/images/logo.png" alt="Hộ Nhâm Logo">
                <span>Showroom Hộ Nhâm</span>
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li><a href="{{ route('products.index') }}">Sản Phẩm</a></li>
                <li><a href="{{ route('inspiration.index') }}">Cảm Hứng</a></li>
                <li><a href="{{ route('admin.dashboard') }}" style="color: var(--color-secondary); font-weight: 600;">Admin</a></li>
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Về Chúng Tôi</h3>
                    <p>Showroom Hộ Nhâm - Vật liệu xây dựng cao cấp với các thương hiệu hàng đầu: Royal, Viglacera, Toto, Fuji.</p>
                </div>
                <div class="footer-section">
                    <h3>Danh Mục</h3>
                    <ul>
                        <li><a href="{{ route('products.index') }}">Gạch Kiến Trúc</a></li>
                        <li><a href="{{ route('products.index') }}">Thiết Bị Vệ Sinh</a></li>
                        <li><a href="{{ route('products.index') }}">Ngói Màu</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Thương Hiệu</h3>
                    <ul>
                        <li><a href="{{ route('products.brand', 'royal') }}">Royal</a></li>
                        <li><a href="{{ route('products.brand', 'viglacera') }}">Viglacera</a></li>
                        <li><a href="{{ route('products.brand', 'toto') }}">Toto</a></li>
                        <li><a href="{{ route('products.brand', 'fuji') }}">Fuji</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Liên Hệ</h3>
                    <p>Email: hungho1991@gmail.com</p>
                    <p>Điện thoại: 0̣914624544</p>
                </div>
            </div>
            <div style="text-align: center; margin-top: var(--spacing-md); padding-top: var(--spacing-md); border-top: 1px solid rgba(255,255,255,0.1);">
                <p>&copy; {{ date('Y') }} Hộ Nhâm. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Fixed Contact Widget -->
    <div style="position: fixed; bottom: 20px; right: 20px; background: transparent; border: none; box-shadow: none; z-index: 999; min-width: 290px; overflow: visible;">
        <!-- Chat Zalo -->
        <a href="https://zalo.me" target="_blank" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; text-decoration: none; transition: all 0.25s ease; color: white; background: rgba(20, 20, 20, 0.6); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; margin-bottom: 8px;" onmouseover="this.style.backgroundColor='rgba(20, 20, 20, 0.8)'; this.style.boxShadow='0 8px 24px rgba(0, 0, 0, 0.3)';" onmouseout="this.style.backgroundColor='rgba(20, 20, 20, 0.6)'; this.style.boxShadow='none';">
            <img src="/images/icon-zalo-3.png" alt="Zalo" style="width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;">
            <div style="flex: 1; min-width: 0;">
                <div style="font-weight: 600; font-size: 0.96rem; margin-bottom: 3px; color: rgba(255, 255, 255, 0.95);">Chat Zalo</div>
                <div style="font-size: 0.78rem; color: rgba(255, 255, 255, 0.5);">(7h30 - 18h00)</div>
            </div>
            <span style="color: rgba(255, 255, 255, 0.4); font-size: 1rem; margin-left: 8px; flex-shrink: 0;">›</span>
        </a>
        
        <!-- Phone -->
        <a href="tel:0977668886" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; text-decoration: none; transition: all 0.25s ease; color: white; background: rgba(20, 20, 20, 0.6); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; margin-bottom: 8px;" onmouseover="this.style.backgroundColor='rgba(20, 20, 20, 0.8)'; this.style.boxShadow='0 8px 24px rgba(0, 0, 0, 0.3)';" onmouseout="this.style.backgroundColor='rgba(20, 20, 20, 0.6)'; this.style.boxShadow='none';">
            <div style="width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #25d366 0%, #20ba5e 100%);">
                <i class="fa fa-phone" style="color: white; font-size: 1.2rem;"></i>
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="font-weight: 600; font-size: 0.96rem; margin-bottom: 3px; color: rgba(255, 255, 255, 0.95);">0977668886</div>
                <div style="font-size: 0.78rem; color: rgba(255, 255, 255, 0.5);">(7h30 - 18h00)</div>
            </div>
            <span style="color: rgba(255, 255, 255, 0.4); font-size: 1rem; margin-left: 8px; flex-shrink: 0;">›</span>
        </a>
        
        <!-- Chat Facebook -->
        <a href="https://www.facebook.com/HoNhamTQ/" target="_blank" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; text-decoration: none; transition: all 0.25s ease; color: white; background: rgba(20, 20, 20, 0.6); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px;" onmouseover="this.style.backgroundColor='rgba(20, 20, 20, 0.8)'; this.style.boxShadow='0 8px 24px rgba(0, 0, 0, 0.3)';" onmouseout="this.style.backgroundColor='rgba(20, 20, 20, 0.6)'; this.style.boxShadow='none';">
            <img src="/images/icon-messenger.png" alt="Messenger" style="width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;">
            <div style="flex: 1; min-width: 0;">
                <div style="font-weight: 600; font-size: 0.96rem; margin-bottom: 3px; color: rgba(255, 255, 255, 0.95);">Chat Facebook</div>
                <div style="font-size: 0.78rem; color: rgba(255, 255, 255, 0.5);">(7h30 - 18h00)</div>
            </div>
            <span style="color: rgba(255, 255, 255, 0.4); font-size: 1rem; margin-left: 8px; flex-shrink: 0;">›</span>
        </a>
    </div>
</body>
</html>
