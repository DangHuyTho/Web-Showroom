@extends('staff.layouts.app')

@section('title', 'Cập nhật tồn kho - ' . $product->name)
@section('page-title', 'Cập Nhật Tồn Kho')

@section('content')
<div style="padding: var(--spacing-lg);">
    <div style="max-width: 800px; margin: 0 auto;">
        <a href="{{ route('staff.inventory.index') }}" style="color: var(--color-primary); text-decoration: none; font-weight: 500; margin-bottom: var(--spacing-md); display: inline-block;">← Quay lại</a>

        <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--color-text); margin-top: 0;">📦 Cập Nhật Tồn Kho</h1>

            <!-- Product Info -->
            <div style="background: #f3f4f6; padding: var(--spacing-lg); border-radius: 6px; margin-bottom: var(--spacing-lg);">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                    <div>
                        <p style="color: #6b7280; font-size: 0.9rem; margin: 0 0 4px 0;">Sản phẩm</p>
                        <p style="font-weight: 600; color: var(--color-text); margin: 0;">{{ $product->name }}</p>
                    </div>
                    <div>
                        <p style="color: #6b7280; font-size: 0.9rem; margin: 0 0 4px 0;">SKU</p>
                        <p style="font-weight: 600; color: var(--color-text); margin: 0; font-family: monospace;">{{ $product->sku ?? '-' }}</p>
                    </div>
                    <div>
                        <p style="color: #6b7280; font-size: 0.9rem; margin: 0 0 4px 0;">Thương hiệu</p>
                        <p style="font-weight: 600; color: var(--color-text); margin: 0;">{{ $product->brand->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p style="color: #6b7280; font-size: 0.9rem; margin: 0 0 4px 0;">Giá</p>
                        <p style="font-weight: 600; color: var(--color-secondary); margin: 0; font-size: 1.1rem;">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                    </div>
                    <div>
                        <p style="color: #6b7280; font-size: 0.9rem; margin: 0 0 4px 0;">Vị trí kệ</p>
                        <p style="font-weight: 600; color: var(--color-text); margin: 0; font-family: monospace; font-size: 1.1rem;">{{ $product->shelf_location ?? '(Chưa xác định)' }}</p>
                    </div>
                </div>
            </div>

            <!-- Update Form -->
            <form action="{{ route('staff.inventory.update', $product->id) }}" method="POST">
                @csrf
                
                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text);">Vị trí kệ</label>
                    <input type="text" name="shelf_location" value="{{ $product->shelf_location }}" placeholder="Ví dụ: A1, B2-3, Kệ 5..." style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 1rem;">
                    <small style="color: #6b7280; display: block; margin-top: 4px;">Vị trí lưu trữ sản phẩm trong kho</small>
                    @error('shelf_location')
                        <p style="color: #ef4444; font-size: 0.9rem; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text);">Số lượng tồn kho hiện tại</label>
                    <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                        <input type="number" name="quantity" value="{{ $product->quantity }}" min="0" required style="flex: 1; padding: 12px; border: 2px solid var(--color-primary); border-radius: 4px; font-size: 1rem; font-weight: 600; color: var(--color-primary);">
                        <span style="background: {{ $product->quantity == 0 ? '#fee2e2' : ($product->quantity <= $product->min_stock ? '#fef3c7' : '#dcfce7') }}; padding: 12px 20px; border-radius: 4px; font-weight: 600; color: {{ $product->quantity == 0 ? '#991b1b' : ($product->quantity <= $product->min_stock ? '#92400e' : '#166534') }};">
                            {{ $product->quantity == 0 ? '⚠️ Hết hàng' : ($product->quantity <= $product->min_stock ? '⚠️ Thấp' : '✓ Đầy đủ') }}
                        </span>
                    </div>
                    @error('quantity')
                        <p style="color: #ef4444; font-size: 0.9rem; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text);">Số lượng tối thiểu cảnh báo</label>
                    <input type="number" name="min_stock" value="{{ $product->min_stock }}" min="0" required style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 1rem;">
                    <small style="color: #6b7280; display: block; margin-top: 4px;">Khi tồn kho ≤ số này, sẽ hiển thị cảnh báo "Thấp"</small>
                    @error('min_stock')
                        <p style="color: #ef4444; font-size: 0.9rem; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text);">Ghi chú</label>
                    <textarea name="notes" placeholder="Nhập ghi chú về việc cập nhật tồn kho (tùy chọn)" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 4px; font-family: inherit; resize: vertical; min-height: 100px;"></textarea>
                    @error('notes')
                        <p style="color: #ef4444; font-size: 0.9rem; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md);">
                    <a href="{{ route('staff.inventory.index') }}" style="background: #f3f4f6; color: #374151; padding: 12px 20px; border-radius: 4px; text-decoration: none; text-align: center; font-weight: 600; transition: all 0.3s;">
                        ← Hủy
                    </a>
                    <button type="submit" style="background: var(--color-secondary); color: white; padding: 12px 20px; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        ✓ Cập nhật
                    </button>
                </div>
            </form>

            <!-- Quick Adjust Form -->
            <div style="border-top: 2px solid #e5e7eb; margin-top: var(--spacing-lg); padding-top: var(--spacing-lg);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">🔄 Điều chỉnh nhanh</h3>
                <form action="{{ route('staff.inventory.adjust', $product->id) }}" method="POST" style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: var(--spacing-md); align-items: flex-end;">
                    @csrf
                    
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text); font-size: 0.9rem;">Số lượng</label>
                        <input type="number" name="adjustment" placeholder="+/-" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px;">
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text); font-size: 0.9rem;">Lý do</label>
                        <select name="reason" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px;">
                            <option value="receive">📦 Nhập hàng</option>
                            <option value="damage">❌ Hư hỏng</option>
                            <option value="return">↩️ Trả lại</option>
                            <option value="other">📝 Khác</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text); font-size: 0.9rem;">Ghi chú</label>
                        <input type="text" name="notes" placeholder="Ghi chú (tùy chọn)" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px;">
                    </div>

                    <button type="submit" style="background: var(--color-primary); color: white; padding: 8px 16px; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: all 0.3s; white-space: nowrap;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                        ✓ Điều chỉnh
                    </button>
                </form>
            </div>

            <!-- Inventory History -->
            <div style="border-top: 2px solid #e5e7eb; margin-top: var(--spacing-lg); padding-top: var(--spacing-lg);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">📋 Lịch sử tồn kho</h3>
                @php
                    $logs = $product->inventoryLogs()->limit(20)->get();
                @endphp
                
                @if ($logs->isEmpty())
                    <p style="color: #6b7280; text-align: center; padding: var(--spacing-lg);">Chưa có lịch sử thay đổi</p>
                @else
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                            <thead>
                                <tr style="background: #f3f4f6;">
                                    <th style="padding: 10px; text-align: left; border: 1px solid #e5e7eb;">Thời gian</th>
                                    <th style="padding: 10px; text-align: left; border: 1px solid #e5e7eb;">Hành động</th>
                                    <th style="padding: 10px; text-align: center; border: 1px solid #e5e7eb;">Thay đổi</th>
                                    <th style="padding: 10px; text-align: center; border: 1px solid #e5e7eb;">Trước / Sau</th>
                                    <th style="padding: 10px; text-align: left; border: 1px solid #e5e7eb;">Nhân viên</th>
                                    <th style="padding: 10px; text-align: left; border: 1px solid #e5e7eb;">Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: 10px; border-right: 1px solid #e5e7eb; font-size: 0.85rem; color: #6b7280;">
                                            {{ $log->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td style="padding: 10px; border-right: 1px solid #e5e7eb;">
                                            <span style="display: inline-block; padding: 4px 8px; border-radius: 3px; font-weight: 600; font-size: 0.8rem;
                                                @switch($log->action_type)
                                                    @case('stock_in') background: #dcfce7; color: #166534; @break
                                                    @case('stock_out') background: #fee2e2; color: #991b1b; @break
                                                    @case('sale') background: #dbeafe; color: #0c2d6b; @break
                                                    @case('adjustment') background: #fef3c7; color: #92400e; @break
                                                    @case('damage') background: #fee2e2; color: #991b1b; @break
                                                    @case('return') background: #dcfce7; color: #166534; @break
                                                    @case('confirm') background: #e0e7ff; color: #312e81; @break
                                                    @default background: #f3f4f6; color: #6b7280;
                                                @endswitch
                                            ">
                                                @switch($log->action_type)
                                                    @case('stock_in') 📦 Nhập hàng @break
                                                    @case('stock_out') 📤 Xuất hàng @break
                                                    @case('sale') 🛒 Bán hàng @break
                                                    @case('adjustment') 🔄 Điều chỉnh @break
                                                    @case('damage') ❌ Hư hỏng @break
                                                    @case('return') ↩️ Trả lại @break
                                                    @case('confirm') ✓ Xác nhận @break
                                                    @default Khác
                                                @endswitch
                                            </span>
                                        </td>
                                        <td style="padding: 10px; border-right: 1px solid #e5e7eb; text-align: center; font-weight: 600;
                                            @if ($log->quantity_changed > 0) color: #10b981;
                                            @else color: #ef4444;
                                            @endif
                                        ">
                                            {{ ($log->quantity_changed > 0 ? '+' : '') }}{{ $log->quantity_changed }}
                                        </td>
                                        <td style="padding: 10px; border-right: 1px solid #e5e7eb; text-align: center; font-size: 0.85rem; color: #6b7280;">
                                            {{ $log->quantity_before }} → {{ $log->quantity_after }}
                                        </td>
                                        <td style="padding: 10px; border-right: 1px solid #e5e7eb; color: #6b7280;">
                                            {{ $log->user?->name ?? 'Hệ thống' }}
                                        </td>
                                        <td style="padding: 10px; font-size: 0.85rem; color: #6b7280;">
                                            {{ $log->notes ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
