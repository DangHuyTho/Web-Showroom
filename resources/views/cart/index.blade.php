@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div style="padding: var(--spacing-lg);">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: var(--spacing-lg); color: var(--color-text);">Giỏ Hàng</h1>

        @if (session('success'))
            <div style="background: #10b981; color: white; padding: var(--spacing-md); border-radius: 8px; margin-bottom: var(--spacing-lg);">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background: #ef4444; color: white; padding: var(--spacing-md); border-radius: 8px; margin-bottom: var(--spacing-lg);">
                {{ session('error') }}
            </div>
        @endif

        @if (count($items) > 0)
            <div style="display: grid; grid-template-columns: 1fr 300px; gap: var(--spacing-lg);">
                <!-- Cart Items -->
                <div>
                    <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f3f4f6; border-bottom: 1px solid #e5e7eb;">
                                    <th style="padding: var(--spacing-md); text-align: left; color: #374151;">Sản phẩm</th>
                                    <th style="padding: var(--spacing-md); text-align: center; color: #374151;">Số lượng</th>
                                    <th style="padding: var(--spacing-md); text-align: right; color: #374151;">Giá</th>
                                    <th style="padding: var(--spacing-md); text-align: right; color: #374151;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: var(--spacing-md);">
                                            <div style="display: flex; gap: var(--spacing-md); align-items: center;">
                                                @if ($item->product->productImages->first())
                                                    <img src="{{ Storage::url($item->product->productImages->first()->image_path) }}" alt="{{ $item->product->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                                @endif
                                                <div>
                                                    <a href="{{ route('products.show', $item->product->slug) }}" style="color: var(--color-primary); font-weight: 500; text-decoration: none;">
                                                        {{ $item->product->name }}
                                                    </a>
                                                    <p style="color: #6b7280; font-size: 0.9rem; margin: 4px 0 0 0;">SKU: {{ $item->product->sku }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: var(--spacing-md); text-align: center;">
                                            <input type="number" min="1" value="{{ $item->quantity }}" style="width: 60px; padding: 6px; border: 1px solid #d1d5db; border-radius: 4px; text-align: center;" data-item-id="{{ $item->id }}">
                                        </td>
                                        <td style="padding: var(--spacing-md); text-align: right;">
                                            <span style="font-weight: 600; color: var(--color-text);">{{ number_format($item->getSubtotal()) }}₫</span>
                                            <p style="color: #6b7280; font-size: 0.85rem; margin: 4px 0 0 0;">{{ number_format($item->unit_price) }}₫ x {{ $item->quantity }}</p>
                                        </td>
                                        <td style="padding: var(--spacing-md); text-align: right;">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; text-decoration: underline; font-size: 0.9rem;">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Continue Shopping -->
                    <div style="margin-top: var(--spacing-lg);">
                        <a href="{{ route('products.index') }}" style="display: inline-block; background: var(--color-primary); color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.background='var(--color-primary-dark)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--color-primary)'; this.style.transform='translateY(0)'">
                            ← Tiếp tục mua sắm
                        </a>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); height: fit-content; position: sticky; top: var(--spacing-lg);">
                    <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: var(--spacing-md); border-bottom: 1px solid #e5e7eb; padding-bottom: var(--spacing-md);">Tóm tắt</h3>
                    
                    <div style="margin-bottom: var(--spacing-md);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; color: #6b7280;">
                            <span>Hàng:</span>
                            <span>{{ number_format($total) }}₫</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; color: #6b7280;">
                            <span>Vận chuyển:</span>
                            <span>Miễn phí</span>
                        </div>
                    </div>

                    <div style="border-top: 2px solid #e5e7eb; padding-top: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                        <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 1.2rem;">
                            <span>Tổng:</span>
                            <span style="color: var(--color-secondary);">{{ number_format($total) }}₫</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}" style="display: block; width: 100%; background: var(--color-secondary); color: white; padding: 12px; border-radius: 4px; text-align: center; text-decoration: none; font-weight: 600; transition: all 0.3s ease; margin-bottom: var(--spacing-md);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(212,175,55,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Thanh toán
                    </a>

                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" style="width: 100%; background: #ef4444; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onclick="return confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm?');" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Xóa tất cả
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div style="background: #f3f4f6; border-radius: 8px; padding: var(--spacing-lg) * 2; text-align: center;">
                <p style="color: #6b7280; font-size: 1.1rem; margin-bottom: var(--spacing-md);">Giỏ hàng của bạn đang trống</p>
                <a href="{{ route('products.index') }}" style="display: inline-block; background: var(--color-primary); color: white; padding: 12px 24px; border-radius: 4px; text-decoration: none; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.background='var(--color-primary-dark)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--color-primary)'; this.style.transform='translateY(0)'">
                    Bắt đầu mua sắm
                </a>
            </div>
        @endif
    </div>
</div>

<script>
    // Auto-update cart quantities
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const quantity = this.value;
            
            fetch(`/cart/update/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    });
</script>
@endsection
