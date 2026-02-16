@extends('layouts.app')

@section('title', $category->name)

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

<section class="section">
    <div class="container">
        <h1 class="section-title">{{ $category->name }}</h1>
        @if($category->description)
        <p class="section-subtitle">{{ $category->description }}</p>
        @endif

        @if($subCategories && $subCategories->count() > 0)
        <div style="margin-bottom: var(--spacing-lg);">
            <h2 style="font-size: 1.5rem; margin-bottom: var(--spacing-md);">Danh Mục Con</h2>
            <div class="grid grid-4">
                @foreach($subCategories as $subCat)
                <a href="{{ route('categories.show', $subCat->slug) }}" class="card" style="text-decoration: none;">
                    <div class="card-image" style="height: 200px;">Hình ảnh {{ $subCat->name }}</div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $subCat->name }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <div class="grid grid-4">
            @forelse($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="card" style="text-decoration: none;">
                <div class="card-image">
                    @if($product->images->count() > 0)
                        Hình ảnh sản phẩm {{ $product->name }}
                    @else
                        Hình ảnh sản phẩm {{ $product->name }}
                    @endif
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $product->name }}</h3>
                    <p class="card-text">{{ $product->brand->name ?? '' }}</p>
                    @if($product->price)
                    <p style="font-weight: 600; color: var(--color-secondary); margin-top: var(--spacing-xs);">
                        {{ number_format($product->price, 0, ',', '.') }} đ/{{ $product->unit }}
                    </p>
                    @endif
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: var(--spacing-lg);">
                <p style="color: var(--color-text-light); font-size: 1.1rem;">Chưa có sản phẩm nào trong danh mục này</p>
            </div>
            @endforelse
        </div>

        @if(isset($products) && method_exists($products, 'links'))
        <div style="margin-top: var(--spacing-md); display: flex; justify-content: center;">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</section>
@endsection
