@extends('layouts.app')

@section('title', 'Dự Toán Vật Tư')

@section('content')
<section class="section">
    <div class="container" style="max-width: 800px;">
        <h1 class="section-title">Dự Toán Vật Tư</h1>
        <p class="section-subtitle">Tính toán số lượng vật liệu cần thiết cho công trình của bạn</p>

        <div style="background: white; padding: var(--spacing-lg); border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <form action="{{ route('calculator.calculate') }}" method="POST">
                @csrf
                <div style="display: grid; gap: var(--spacing-md);">
                    <div>
                        <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500;">Loại sản phẩm *</label>
                        <select name="product_type" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border);">
                            <option value="">Chọn loại sản phẩm</option>
                            <option value="tile">Gạch lát nền/ốp tường</option>
                            <option value="roof_tile">Ngói mái</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500;">Diện tích (m²) *</label>
                        <input type="number" name="area" step="0.1" min="0.1" required placeholder="Ví dụ: 50" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border);">
                    </div>

                    <div id="size-field" style="display: none;">
                        <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500;">Kích thước gạch *</label>
                        <select name="size" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border);">
                            <option value="">Chọn kích thước</option>
                            <option value="60x60">60x60 cm</option>
                            <option value="80x80">80x80 cm</option>
                            <option value="60x120">60x120 cm</option>
                            <option value="30x60">30x60 cm</option>
                            <option value="40x40">40x40 cm</option>
                        </select>
                    </div>

                    <button type="submit" class="btn" style="width: 100%;">Tính Toán</button>
                </div>
            </form>
        </div>

        <!-- Instructions -->
        <div style="margin-top: var(--spacing-lg); background: var(--color-accent); padding: var(--spacing-md); border-radius: 8px;">
            <h3 style="font-size: 1.25rem; margin-bottom: var(--spacing-sm);">Hướng Dẫn Sử Dụng</h3>
            <ul style="list-style: none; padding-left: 0; line-height: 1.8;">
                <li>✓ Chọn loại sản phẩm bạn muốn tính toán</li>
                <li>✓ Nhập diện tích cần lát/ốp (tính bằng m²)</li>
                <li>✓ Đối với gạch, chọn kích thước phù hợp</li>
                <li>✓ Hệ thống sẽ tự động tính toán số lượng cần thiết (đã bao gồm 10% hao hụt)</li>
            </ul>
        </div>
    </div>
</section>

<script>
    document.querySelector('select[name="product_type"]').addEventListener('change', function() {
        const sizeField = document.getElementById('size-field');
        if (this.value === 'tile') {
            sizeField.style.display = 'block';
            sizeField.querySelector('select[name="size"]').required = true;
        } else {
            sizeField.style.display = 'none';
            sizeField.querySelector('select[name="size"]').required = false;
        }
    });
</script>
@endsection
