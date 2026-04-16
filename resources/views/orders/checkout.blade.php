@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div style="padding: var(--spacing-lg);">
    <div style="max-width: 900px; margin: 0 auto;">
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: var(--spacing-lg); color: var(--color-text);">Thanh Toán</h1>

        @if (session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: var(--spacing-md); border-radius: 8px; margin-bottom: var(--spacing-lg);">
                {{ session('error') }}
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 350px; gap: var(--spacing-lg);">
            <!-- Order Form -->
            <div>
                <form action="{{ route('orders.store') }}" method="POST" style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    @csrf

                    <!-- Delivery Address -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <h3 style="font-weight: 600; margin-bottom: var(--spacing-md); color: var(--color-text);">Địa chỉ giao hàng</h3>
                        <textarea name="delivery_address" required placeholder="Nhập địa chỉ giao hàng" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 4px; font-family: inherit; resize: vertical;" rows="3">{{ old('delivery_address') }}</textarea>
                        @error('delivery_address')
                            <p style="color: #ef4444; font-size: 0.9rem; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text);">Số điện thoại</label>
                        <input type="text" name="phone" required placeholder="Ví dụ: 0912345678" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 4px;" value="{{ old('phone') }}">
                        @error('phone')
                            <p style="color: #ef4444; font-size: 0.9rem; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text);">Ghi chú (tùy chọn)</label>
                        <textarea name="notes" placeholder="Thêm ghi chú cho đơn hàng" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 4px; font-family: inherit; resize: vertical;" rows="3">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Payment Method -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <h3 style="font-weight: 600; margin-bottom: var(--spacing-md); color: var(--color-text);">Phương thức thanh toán</h3>
                        
                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: flex; align-items: center; padding: 12px; border: 2px solid #e5e7eb; border-radius: 4px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='var(--color-secondary)'; this.style.backgroundColor='#fffbf0'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='transparent'">
                                <input type="radio" name="payment_method" value="direct_payment" required {{ old('payment_method') === 'direct_payment' ? 'checked' : '' }} style="margin-right: var(--spacing-sm);">
                                <div>
                                    <strong style="display: block; color: var(--color-text);">Thanh toán trực tiếp</strong>
                                    <small style="color: #6b7280; display: block;">Thanh toán khi nhận hàng hoặc chuyển khoản</small>
                                </div>
                            </label>
                        </div>

                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: flex; align-items: center; padding: 12px; border: 2px solid #e5e7eb; border-radius: 4px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='var(--color-secondary)'; this.style.backgroundColor='#fffbf0'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='transparent'">
                                <input type="radio" name="payment_method" value="banking" required {{ old('payment_method') === 'banking' ? 'checked' : '' }} style="margin-right: var(--spacing-sm);">
                                <div>
                                    <strong style="display: block; color: var(--color-text);">Chuyển khoản ngân hàng</strong>
                                    <small style="color: #6b7280; display: block;">Chuyển khoản trực tiếp đến tài khoản ngân hàng</small>
                                </div>
                            </label>
                        </div>

                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: flex; align-items: center; padding: 12px; border: 2px solid #e5e7eb; border-radius: 4px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='var(--color-secondary)'; this.style.backgroundColor='#fffbf0'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='transparent'">
                                <input type="radio" name="payment_method" value="credit_card" required {{ old('payment_method') === 'credit_card' ? 'checked' : '' }} style="margin-right: var(--spacing-sm);">
                                <div>
                                    <strong style="display: block; color: var(--color-text);">Thẻ tín dụng</strong>
                                    <small style="color: #6b7280; display: block;">Visa, Mastercard, hoặc các thẻ khác</small>
                                </div>
                            </label>
                        </div>

                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: flex; align-items: center; padding: 12px; border: 2px solid #e5e7eb; border-radius: 4px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='var(--color-secondary)'; this.style.backgroundColor='#fffbf0'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='transparent'">
                                <input type="radio" name="payment_method" value="e_wallet" required {{ old('payment_method') === 'e_wallet' ? 'checked' : '' }} style="margin-right: var(--spacing-sm);">
                                <div>
                                    <strong style="display: block; color: var(--color-text);">Ví điện tử</strong>
                                    <small style="color: #6b7280; display: block;">Momo, ZaloPay, hoặc ví khác</small>
                                </div>
                            </label>
                        </div>

                        @error('payment_method')
                            <p style="color: #ef4444; font-size: 0.9rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" style="width: 100%; background: var(--color-secondary); color: white; padding: 12px; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(212,175,55,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Tiếp tục thanh toán
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); height: fit-content; position: sticky; top: var(--spacing-lg);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md); border-bottom: 1px solid #e5e7eb; padding-bottom: var(--spacing-md);">Đơn hàng</h3>
                
                @foreach ($items as $item)
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm); padding-bottom: var(--spacing-sm); border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280;">{{ $item->product->name }} x{{ $item->quantity }}</span>
                        <span style="font-weight: 600;">{{ number_format($item->product->price * $item->quantity) }}₫</span>
                    </div>
                @endforeach

                <div style="border-top: 2px solid #e5e7eb; margin-top: var(--spacing-md); padding-top: var(--spacing-md);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                        <span style="color: #6b7280;">Hàng:</span>
                        <span>{{ number_format($total) }}₫</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-md);">
                        <span style="color: #6b7280;">Vận chuyển:</span>
                        <span>Miễn phí</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 1.1rem;">
                        <span>Tổng:</span>
                        <span style="color: var(--color-secondary);">{{ number_format($total) }}₫</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
