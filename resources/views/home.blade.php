@extends('layouts.app')

@section('title', 'Trang Chủ - Hộ Nhâm Showroom')

@section('content')
<!-- Hero Banner Carousel -->
<section style="position: relative; width: 100%; height: 500px; overflow: hidden;">
    <div class="hero-carousel" style="position: relative; width: 100%; height: 100%; touch-action: pan-y;">
        <!-- Banner Slides -->
        <div class="carousel-track" style="display: flex; width: 100%; height: 100%; transition: transform 0.5s ease-in-out;">
            <div class="carousel-slide" style="min-width: 100%; height: 100%; position: relative;">
                <div style="background: url('/images/hero_banner1.png') center/cover; height: 100%;"></div>
            </div>
            <div class="carousel-slide" style="min-width: 100%; height: 100%; position: relative;">
                <div style="background: url('/images/hero_banner2.png') center/cover; height: 100%;"></div>
            </div>
            <div class="carousel-slide" style="min-width: 100%; height: 100%; position: relative;">
                <div style="background: url('/images/hero_banner3.png') center/cover; height: 100%;"></div>
            </div>
            <div class="carousel-slide" style="min-width: 100%; height: 100%; position: relative;">
                <div style="background: url('/images/hero_banner4.jpg') center/cover; height: 100%;"></div>
            </div>
        </div>

        <!-- Overlay Content -->
        <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.1) 100%); z-index: 5;">
            <div style="text-align: center; color: white; max-width: 800px; padding: var(--spacing-md);">
                <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: var(--spacing-md); font-family: 'Playfair Display', serif; line-height: 1.2; text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
                    Showroom Vật Liệu Xây Dựng Cao Cấp
                </h1>
                <p style="font-size: 1.25rem; margin-bottom: var(--spacing-md); color: rgba(255,255,255,0.95); line-height: 1.6; text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
                    Tìm kiếm giải pháp hoàn hảo cho ngôi nhà của bạn với các sản phẩm chất lượng từ các thương hiệu hàng đầu
                </p>
                <div style="display: flex; gap: var(--spacing-sm); justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('products.index') }}" class="btn" style="background: var(--color-secondary); color: var(--color-primary); font-weight: 600;">Khám Phá Sản Phẩm</a>
                    <a href="{{ route('inspiration.index') }}" class="btn btn-secondary" style="border-color: white; color: white;">Xem Cảm Hứng</a>
                </div>
            </div>
        </div>

        <!-- Navigation Dots -->
        <div class="carousel-dots" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 12px; z-index: 10;">
            <button class="carousel-dot active" data-index="0" style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255,255,255,0.8); border: none; cursor: pointer; transition: all 0.3s ease;"></button>
            <button class="carousel-dot" data-index="1" style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255,255,255,0.5); border: none; cursor: pointer; transition: all 0.3s ease;"></button>
            <button class="carousel-dot" data-index="2" style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255,255,255,0.5); border: none; cursor: pointer; transition: all 0.3s ease;"></button>
            <button class="carousel-dot" data-index="3" style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255,255,255,0.5); border: none; cursor: pointer; transition: all 0.3s ease;"></button>
        </div>

        <!-- Arrow Navigation -->
        <button class="carousel-prev" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 12px 16px; font-size: 24px; cursor: pointer; z-index: 10; border-radius: 4px; transition: all 0.3s ease;">❮</button>
        <button class="carousel-next" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 12px 16px; font-size: 24px; cursor: pointer; z-index: 10; border-radius: 4px; transition: all 0.3s ease;">❯</button>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.querySelector('.carousel-track');
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    const carousel = document.querySelector('.hero-carousel');
    
    let currentIndex = 0;
    let autoplayInterval = null;
    let startX = 0;
    let currentX = 0;
    let isDragging = false;
    let isMouseOver = false;

    const totalSlides = slides.length;
    const AUTOPLAY_DELAY = 5000; // 5 giây
    const DRAG_THRESHOLD = 50;

    // Update track position
    function updateTrack() {
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
        dots.forEach((dot, idx) => {
            dot.classList.toggle('active', idx === currentIndex);
            dot.style.background = idx === currentIndex ? 'rgba(255,255,255,0.8)' : 'rgba(255,255,255,0.5)';
        });
    }

    // Next slide
    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateTrack();
    }

    // Previous slide
    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateTrack();
    }

    // Start autoplay
    function startAutoplay() {
        if (autoplayInterval) clearInterval(autoplayInterval);
        autoplayInterval = setInterval(() => {
            if (!isMouseOver && !isDragging) {
                nextSlide();
            }
        }, AUTOPLAY_DELAY);
    }

    // Stop autoplay
    function stopAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
    }

    // Mouse/Touch Events for drag
    carousel.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.clientX;
        currentX = 0;
        track.style.transition = 'none';
        stopAutoplay();
    }, false);

    carousel.addEventListener('touchstart', (e) => {
        isDragging = true;
        startX = e.touches[0].clientX;
        currentX = 0;
        track.style.transition = 'none';
        stopAutoplay();
    }, false);

    document.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        currentX = e.clientX - startX;
        track.style.transform = `translateX(calc(-${currentIndex * 100}% + ${currentX}px))`;
    }, false);

    document.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        currentX = e.touches[0].clientX - startX;
        track.style.transform = `translateX(calc(-${currentIndex * 100}% + ${currentX}px))`;
    }, false);

    document.addEventListener('mouseup', endDrag, false);
    document.addEventListener('touchend', endDrag, false);

    function endDrag() {
        if (!isDragging) return;
        isDragging = false;
        track.style.transition = 'transform 0.5s ease-in-out';

        if (currentX > DRAG_THRESHOLD) {
            prevSlide();
        } else if (currentX < -DRAG_THRESHOLD) {
            nextSlide();
        } else {
            updateTrack();
        }
        currentX = 0;
        
        if (!isMouseOver) {
            startAutoplay();
        }
    }

    // Button controls
    prevBtn.addEventListener('click', () => {
        prevSlide();
        stopAutoplay();
        if (!isMouseOver) {
            setTimeout(startAutoplay, 500);
        }
    });

    nextBtn.addEventListener('click', () => {
        nextSlide();
        stopAutoplay();
        if (!isMouseOver) {
            setTimeout(startAutoplay, 500);
        }
    });

    // Dot controls
    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            currentIndex = parseInt(dot.dataset.index);
            updateTrack();
            stopAutoplay();
            if (!isMouseOver) {
                setTimeout(startAutoplay, 500);
            }
        });
    });

    // Hover effects for arrows
    prevBtn.addEventListener('mouseover', function() { this.style.background = 'rgba(0,0,0,0.7)'; });
    prevBtn.addEventListener('mouseout', function() { this.style.background = 'rgba(0,0,0,0.5)'; });
    nextBtn.addEventListener('mouseover', function() { this.style.background = 'rgba(0,0,0,0.7)'; });
    nextBtn.addEventListener('mouseout', function() { this.style.background = 'rgba(0,0,0,0.5)'; });

    // Pause autoplay on hover
    carousel.addEventListener('mouseenter', () => {
        isMouseOver = true;
        stopAutoplay();
    });

    carousel.addEventListener('mouseleave', () => {
        isMouseOver = false;
        if (!isDragging) {
            startAutoplay();
        }
    });

    // Start autoplay on load
    startAutoplay();
});
</script>


<!-- Shop by Brand -->
<section class="section">
    <div class="container">
        <div style="text-align: center; margin-bottom: var(--spacing-lg);">
            <h2 class="section-title">🏢 Mua Sắm Theo Thương Hiệu</h2>
            <p class="section-subtitle">Khám phá hệ sinh thái sản phẩm từ các thương hiệu hàng đầu thế giới</p>
        </div>
        <div class="grid grid-4" style="gap: var(--spacing-md);">
            @forelse($brands as $brand)
            @php
                $logoMap = [
                    'royal' => 'royal_logo.png',
                    'viglacera' => 'VIglacera_logo.png',
                    'toto' => 'toto_logo.png',
                    'fuji' => 'fuji_logo.jpg'
                ];
                $logoFile = $logoMap[$brand->slug] ?? null;
            @endphp
            <a href="{{ route('products.brand', $brand->slug) }}" class="card" style="text-decoration: none; transition: all 0.3s ease; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: 1px solid #e5e5e5; cursor: pointer; hover: transform 0.3s ease;">
                <div style="background: linear-gradient(135deg, #f5f5f0 0%, #e8e8e0 100%); padding: 40px; display: flex; align-items: center; justify-content: center; height: 200px; border-bottom: 1px solid #e5e5e5; gap: 0;">
                    @if($logoFile && file_exists(public_path('images/' . $logoFile)))
                        <img src="/images/{{ $logoFile }}" alt="{{ $brand->name }} Logo" style="max-width: 85%; max-height: 150px; object-fit: contain; display: block; margin: auto;">
                    @else
                        <div style="font-weight: 600; font-size: 1.1rem; color: var(--color-primary);">{{ $brand->name }}</div>
                    @endif
                </div>
                <div class="card-body">
                    <h3 class="card-title" style="color: var(--color-primary); font-weight: 600;">{{ $brand->name }}</h3>
                    <p class="card-text" style="color: var(--color-text-light); font-size: 0.9rem;">{{ Str::limit($brand->description ?? 'Thương hiệu cao cấp', 100) }}</p>
                    <p style="color: var(--color-secondary); font-weight: 600; margin-top: var(--spacing-xs);">Xem sản phẩm →</p>
                </div>
            </a>
            @empty
            <a href="{{ route('products.brand', 'royal') }}" class="card" style="text-decoration: none; transition: all 0.3s ease; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="background: linear-gradient(135deg, #f5f5f0 0%, #e8e8e0 100%); padding: 40px; display: flex; align-items: center; justify-content: center; height: 200px; gap: 0;"><img src="/images/royal_logo.png" alt="Royal Logo" style="max-width: 85%; max-height: 150px; object-fit: contain; display: block; margin: auto;"></div>
                <div class="card-body"><h3 class="card-title" style="color: var(--color-primary);">Royal</h3><p class="card-text">Gạch kiến trúc cao cấp</p><p style="color: var(--color-secondary); font-weight: 600; margin-top: var(--spacing-xs);">Xem sản phẩm →</p></div>
            </a>
            <a href="{{ route('products.brand', 'viglacera') }}" class="card" style="text-decoration: none; transition: all 0.3s ease; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="background: linear-gradient(135deg, #f5f5f0 0%, #e8e8e0 100%); padding: 40px; display: flex; align-items: center; justify-content: center; height: 200px; gap: 0;"><img src="/images/VIglacera_logo.png" alt="Viglacera Logo" style="max-width: 85%; max-height: 150px; object-fit: contain; display: block; margin: auto;"></div>
                <div class="card-body"><h3 class="card-title" style="color: var(--color-primary);">Viglacera</h3><p class="card-text">Gạch kiến trúc chất lượng</p><p style="color: var(--color-secondary); font-weight: 600; margin-top: var(--spacing-xs);">Xem sản phẩm →</p></div>
            </a>
            <a href="{{ route('products.brand', 'toto') }}" class="card" style="text-decoration: none; transition: all 0.3s ease; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="background: linear-gradient(135deg, #f5f5f0 0%, #e8e8e0 100%); padding: 40px; display: flex; align-items: center; justify-content: center; height: 200px; gap: 0;"><img src="/images/toto_logo.png" alt="Toto Logo" style="max-width: 85%; max-height: 150px; object-fit: contain; display: block; margin: auto;"></div>
                <div class="card-body"><h3 class="card-title" style="color: var(--color-primary);">Toto</h3><p class="card-text">Thiết bị vệ sinh cao cấp</p><p style="color: var(--color-secondary); font-weight: 600; margin-top: var(--spacing-xs);">Xem sản phẩm →</p></div>
            </a>
            <a href="{{ route('products.brand', 'fuji') }}" class="card" style="text-decoration: none; transition: all 0.3s ease; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="background: linear-gradient(135deg, #f5f5f0 0%, #e8e8e0 100%); padding: 40px; display: flex; align-items: center; justify-content: center; height: 200px; gap: 0;"><img src="/images/fuji_logo.jpg" alt="Fuji Logo" style="max-width: 85%; max-height: 150px; object-fit: contain; display: block; margin: auto;"></div>
                <div class="card-body"><h3 class="card-title" style="color: var(--color-primary);">Fuji</h3><p class="card-text">Ngói màu cao cấp</p><p style="color: var(--color-secondary); font-weight: 600; margin-top: var(--spacing-xs);">Xem sản phẩm →</p></div>
            </a>
            @endforelse
        </div>
    </div>
</section>

<!-- Shop by Room -->
<section class="section" style="background: linear-gradient(135deg, var(--color-accent) 0%, #f0ebe5 100%);">
    <div class="container">
        <div style="text-align: center; margin-bottom: var(--spacing-lg);">
            <h2 class="section-title">🏠 Mua Sắm Theo Không Gian</h2>
            <p class="section-subtitle">Tìm sản phẩm phù hợp cho từng không gian trong ngôi nhà của bạn</p>
        </div>
        <div class="grid grid-4" style="gap: var(--spacing-md);">
            <a href="{{ route('products.index', ['space' => 'living_room']) }}" class="card" style="text-decoration: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                <div style="background: url('/images/phong-khach.png') center/cover; height: 200px;"></div>
                <div class="card-body"><h3 class="card-title">Phòng Khách</h3><p class="card-text">Gạch lát nền và ốp tường cao cấp</p></div>
            </a>
            <a href="{{ route('products.index', ['space' => 'kitchen']) }}" class="card" style="text-decoration: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                <div style="background: url('/images/nha-bep.png') center/cover; height: 200px;"></div>
                <div class="card-body"><h3 class="card-title">Nhà Bếp</h3><p class="card-text">Gạch chống trơn và dễ vệ sinh</p></div>
            </a>
            <a href="{{ route('products.index', ['space' => 'bathroom']) }}" class="card" style="text-decoration: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                <div style="background: url('/images/phong-tam.png') center/cover; height: 200px;"></div>
                <div class="card-body"><h3 class="card-title">Phòng Tắm</h3><p class="card-text">Thiết bị vệ sinh và gạch ốp</p></div>
            </a>
            <a href="{{ route('products.index', ['space' => 'outdoor']) }}" class="card" style="text-decoration: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                <div style="background: url('/images/ngoai-that.png') center/cover; height: 200px;"></div>
                <div class="card-body"><h3 class="card-title">Ngoại Thất</h3><p class="card-text">Gạch sân vườn và ngói mái</p></div>
            </a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section">
    <div class="container">
        <div style="text-align: center; margin-bottom: var(--spacing-lg);">
            <h2 class="section-title">⭐ Sản Phẩm Nổi Bật</h2>
            <p class="section-subtitle">Những sản phẩm được yêu thích nhất của chúng tôi</p>
        </div>
        <div class="grid grid-4" style="gap: var(--spacing-md);">
            @forelse($featuredProducts as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="card" style="text-decoration: none; display: flex; flex-direction: column; height: 100%; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                @php
                    $primaryImage = $product->images()->where('is_primary', true)->first() ?? $product->images->first();
                @endphp
                <div style="background-size: cover; background-position: center; overflow: hidden; height: 220px; position: relative;">
                    @if($primaryImage)
                        <img src="{{ asset($primaryImage->image_path) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 500;">
                            {{ substr($product->name, 0, 20) }}...
                        </div>
                    @endif
                    <div style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">⭐ Nổi bật</div>
                </div>
                <div class="card-body" style="flex: 1; display: flex; flex-direction: column;">
                    <h3 class="card-title" style="color: var(--color-primary); font-size: 0.95rem;">{{ substr($product->name, 0, 40) }}</h3>
                    <p class="card-text" style="color: var(--color-text-light); font-size: 0.85rem;">{{ $product->brand->name ?? '' }}</p>
                    @if($product->price)
                    <p style="font-weight: 700; color: var(--color-secondary); margin-top: auto; margin-bottom: 0.5rem; font-size: 1.1rem;">
                        {{ number_format($product->price, 0, ',', '.') }} ₫
                    </p>
                    <p style="color: var(--color-text-light); font-size: 0.85rem;">/ {{ $product->unit }}</p>
                    @endif
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; padding: var(--spacing-lg); text-align: center; color: var(--color-text-light);">
                <p style="font-size: 1.1rem;">📦 Chưa có sản phẩm nổi bật</p>
            </div>
            @endforelse
        </div>
        <div style="text-align: center; margin-top: var(--spacing-lg);">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Xem Tất Cả Sản Phẩm</a>
        </div>
    </div>
</section>

<!-- Featured Projects -->
<section class="section" style="background: linear-gradient(135deg, #f5f5f0 0%, #ebe6dd 100%);">
    <div class="container">
        <div style="text-align: center; margin-bottom: var(--spacing-lg);">
            <h2 class="section-title">🎨 Công Trình Thực Tế</h2>
            <p class="section-subtitle">Khám phá các dự án đã hoàn thiện với sản phẩm của chúng tôi</p>
        </div>
        <div class="grid grid-3" style="gap: var(--spacing-md);">
            @forelse($featuredProjects as $project)
            <a href="{{ route('inspiration.show', $project->slug) }}" class="card" style="text-decoration: none; transition: all 0.3s ease; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="background: url('/images/{{ $project->featured_image ?? $project->slug . '.png' }}') center/cover; height: 280px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 500;">
                </div>
                <div class="card-body">
                    <h3 class="card-title" style="color: var(--color-primary);">{{ $project->title }}</h3>
                    <p class="card-text" style="color: var(--color-text-light); font-size: 0.9rem;">{{ Str::limit($project->excerpt ?? $project->content, 150) }}</p>
                    @if($project->project_location)
                    <p style="color: var(--color-secondary); font-weight: 600; margin-top: var(--spacing-sm); font-size: 0.9rem;">
                        📍 {{ $project->project_location }}
                    </p>
                    @endif
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; padding: var(--spacing-lg); text-align: center; color: var(--color-text-light);">
                <p style="font-size: 1.1rem;">🖼️ Chưa có dự án nào</p>
            </div>
            @endforelse
        </div>
        <div style="text-align: center; margin-top: var(--spacing-lg);">
            <a href="{{ route('inspiration.index') }}" class="btn btn-secondary">Xem Tất Cả Cảm Hứng</a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: linear-gradient(135deg, var(--color-primary) 0%, #2d2d2d 100%); color: white; padding: 80px var(--spacing-md); text-align: center;">
    <div class="container" style="max-width: 600px;">
        <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: var(--spacing-md); font-family: 'Playfair Display', serif;">
            Cần Tư Vấn?
        </h2>
        <p style="font-size: 1.1rem; margin-bottom: var(--spacing-md); color: rgba(255,255,255,0.9);">
            Liên hệ với chúng tôi để được tư vấn miễn phí về các giải pháp tối ưu cho dự án của bạn
        </p>
        <a href="#" class="btn" style="background: var(--color-secondary); color: var(--color-primary); font-weight: 600; display: inline-block;">Liên Hệ Ngay</a>
    </div>
</section>
@endsection
