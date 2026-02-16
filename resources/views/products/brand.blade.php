@extends('layouts.app')

@section('title', $brand->name)

@section('content')
<section class="section">
    <div class="container">
        <h1 class="section-title">{{ $brand->name }}</h1>
        @if($brand->description)
        <p class="section-subtitle">{{ $brand->description }}</p>
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
                    @if($product->size)
                    <p style="color: var(--color-text-light); font-size: 0.9rem;">Kích thước: {{ $product->size }}</p>
                    @endif
                    @if($product->price)
                    <p style="font-weight: 600; color: var(--color-secondary); margin-top: var(--spacing-xs);">
                        {{ number_format($product->price, 0, ',', '.') }} đ/{{ $product->unit }}
                    </p>
                    @endif
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: var(--spacing-lg);">
                <p style="color: var(--color-text-light); font-size: 1.1rem;">Chưa có sản phẩm nào cho thương hiệu này</p>
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
