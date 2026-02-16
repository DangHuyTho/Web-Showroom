@extends('layouts.app')

@section('title', 'Kết Quả Dự Toán')

@section('content')
<section class="section">
    <div class="container" style="max-width: 800px;">
        <h1 class="section-title">Kết Quả Dự Toán</h1>

        <div style="background: white; padding: var(--spacing-lg); border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: var(--spacing-md);">
            <div style="display: grid; gap: var(--spacing-md);">
                <div>
                    <h2 style="font-size: 1.5rem; margin-bottom: var(--spacing-sm);">Thông Tin Đầu Vào</h2>
                    <div style="display: grid; gap: var(--spacing-xs);">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Loại sản phẩm:</span>
                            <strong>{{ $productType === 'tile' ? 'Gạch lát nền/ốp tường' : 'Ngói mái' }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Diện tích:</span>
                            <strong>{{ number_format($area, 2) }} m²</strong>
                        </div>
                        @if($productType === 'tile')
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Kích thước:</span>
                            <strong>{{ $size }} cm</strong>
                        </div>
                        @endif
                    </div>
                </div>

                <div style="border-top: 1px solid var(--color-border); padding-top: var(--spacing-md);">
                    <h2 style="font-size: 1.5rem; margin-bottom: var(--spacing-sm);">Kết Quả Tính Toán</h2>
                    @if($productType === 'tile')
                    <div style="display: grid; gap: var(--spacing-sm);">
                        <div style="display: flex; justify-content: space-between; padding: var(--spacing-sm); background: var(--color-accent); border-radius: 4px;">
                            <span style="font-weight: 500;">Số viên gạch cần thiết:</span>
                            <strong style="font-size: 1.25rem; color: var(--color-secondary);">{{ number_format($result['tiles_needed']) }} viên</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: var(--spacing-sm);">
                            <span style="color: var(--color-text-light);">Số thùng cần thiết (ước tính):</span>
                            <strong>{{ number_format($result['boxes_needed']) }} thùng</strong>
                        </div>
                        <p style="color: var(--color-text-light); font-size: 0.9rem; margin-top: var(--spacing-xs);">
                            * Đã tính thêm 10% hao hụt trong quá trình thi công
                        </p>
                    </div>
                    @else
                    <div style="display: grid; gap: var(--spacing-sm);">
                        <div style="display: flex; justify-content: space-between; padding: var(--spacing-sm); background: var(--color-accent); border-radius: 4px;">
                            <span style="font-weight: 500;">Số viên ngói cần thiết:</span>
                            <strong style="font-size: 1.25rem; color: var(--color-secondary);">{{ number_format($result['tiles_needed']) }} viên</strong>
                        </div>
                        <p style="color: var(--color-text-light); font-size: 0.9rem; margin-top: var(--spacing-xs);">
                            * Đã tính thêm 10% hao hụt trong quá trình thi công
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div style="display: flex; gap: var(--spacing-sm); justify-content: center;">
            <a href="{{ route('calculator.index') }}" class="btn btn-secondary">Tính Lại</a>
            <a href="{{ route('products.index') }}" class="btn">Xem Sản Phẩm</a>
        </div>
    </div>
</section>
@endsection
