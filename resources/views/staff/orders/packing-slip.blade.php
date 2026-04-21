@extends('layouts.app')

@section('title', 'In Vận Đơn - Đơn #' . $order->id)

@section('content')
<div style="padding: var(--spacing-lg);">
    <div style="max-width: 900px; margin: 0 auto;">
        <!-- Packing Slip Container -->
        <div id="packing-slip" style="background: white; padding: 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px;">
            <!-- Header -->
            <div style="text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #000;">
                <h1 style="margin: 0; font-size: 24px; font-weight: 700;">PHIẾU ĐÓNG GÓI / VẬN ĐƠN</h1>
                <p style="margin: 5px 0; color: #6b7280;">Đơn hàng #{{ $order->id }} - {{ now()->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Order Info Section -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                <!-- Customer Info -->
                <div>
                    <h3 style="margin: 0 0 10px 0; font-size: 14px; font-weight: 700; text-transform: uppercase;">Thông Tin Khách Hàng</h3>
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <tr>
                            <td style="padding: 4px 0; font-weight: 600;">Tên:</td>
                            <td style="padding: 4px 0; padding-left: 10px;">{{ $order->user->name }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; font-weight: 600;">Điện thoại:</td>
                            <td style="padding: 4px 0; padding-left: 10px;">{{ $order->phone }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; font-weight: 600;">Email:</td>
                            <td style="padding: 4px 0; padding-left: 10px; font-size: 12px;">{{ $order->user->email }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Delivery Info -->
                <div>
                    <h3 style="margin: 0 0 10px 0; font-size: 14px; font-weight: 700; text-transform: uppercase;">Địa Chỉ Giao Hàng</h3>
                    <p style="margin: 0; font-size: 13px; line-height: 1.5; padding: 4px 0;">{{ $order->delivery_address }}</p>
                </div>
            </div>

            <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #e5e7eb;">
                <!-- Order Summary -->
                <h3 style="margin: 0 0 10px 0; font-size: 14px; font-weight: 700; text-transform: uppercase;">Chi Tiết Đơn Hàng</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <tr style="background: #f3f4f6;">
                        <th style="padding: 8px; text-align: left; border: 1px solid #d1d5db;">STT</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #d1d5db;">Sản Phẩm</th>
                        <th style="padding: 8px; text-align: center; border: 1px solid #d1d5db;">SKU</th>
                        <th style="padding: 8px; text-align: center; border: 1px solid #d1d5db;">SL</th>
                        <th style="padding: 8px; text-align: center; border: 1px solid #d1d5db;">Vị Trí Kệ</th>
                    </tr>
                    @forelse($order->items as $index => $item)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #d1d5db;">{{ $index + 1 }}</td>
                            <td style="padding: 8px; border: 1px solid #d1d5db;">{{ $item->product->name }}</td>
                            <td style="padding: 8px; border: 1px solid #d1d5db; text-align: center;">{{ $item->product->sku }}</td>
                            <td style="padding: 8px; border: 1px solid #d1d5db; text-align: center; font-weight: 600;">{{ $item->quantity }}</td>
                            <td style="padding: 8px; border: 1px solid #d1d5db; text-align: center;">{{ $item->product->shelf_location ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 8px; border: 1px solid #d1d5db; text-align: center; color: #9ca3af;">Không có sản phẩm</td>
                        </tr>
                    @endforelse
                </table>
            </div>

            <!-- Signature Area -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 30px; margin-top: 40px; font-size: 12px;">
                <div style="text-align: center;">
                    <p style="margin: 0 0 30px 0;">Người lấy hàng<br>(Ký, ghi rõ họ tên)</p>
                    <div style="border-top: 1px solid #000; padding-top: 5px; min-height: 20px;"></div>
                </div>
                <div style="text-align: center;">
                    <p style="margin: 0 0 30px 0;">Người đóng gói<br>(Ký, ghi rõ họ tên)</p>
                    <div style="border-top: 1px solid #000; padding-top: 5px; min-height: 20px;"></div>
                </div>
                <div style="text-align: center;">
                    <p style="margin: 0 0 30px 0;">Người quản lý<br>(Ký, ghi rõ họ tên)</p>
                    <div style="border-top: 1px solid #000; padding-top: 5px; min-height: 20px;"></div>
                </div>
            </div>

            <!-- Footer Notes -->
            <div style="margin-top: 30px; padding: 15px; background: #f9fafb; border-radius: 4px; font-size: 12px; color: #6b7280;">
                @if ($order->notes)
                    <p style="margin: 0 0 8px 0;"><strong>Ghi chú:</strong> {{ $order->notes }}</p>
                @endif
                <p style="margin: 0;">Tổng tiền: <strong style="color: #374151;">{{ number_format($order->total_amount) }} đ</strong></p>
            </div>
        </div>

        <!-- Print and Action Buttons -->
        <div style="margin-top: var(--spacing-lg); display: flex; gap: var(--spacing-md); justify-content: center;">
            <button onclick="window.print()" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500;">
                🖨️ In Phiếu
            </button>
            <a href="{{ route('staff.orders.show', $order->id) }}" style="background: var(--color-primary); color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 500; display: inline-block;">
                ← Quay Lại
            </a>
        </div>
    </div>
</div>

<style>
    @media print {
        body {
            margin: 0;
            padding: 0;
        }
        div[style*="margin-top: var(--spacing-lg)"] {
            display: none;
        }
        #packing-slip {
            box-shadow: none;
            page-break-after: always;
        }
    }
</style>
@endsection
