@extends('layouts.app')

@section('title', 'Quản lý ảnh - ' . $product->name)

@section('content')
<section class="section">
    <div class="container" style="max-width: 1000px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
            <h1>📸 Quản lý ảnh sản phẩm</h1>
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn" style="background: var(--color-primary); color: white;">← Quay lại</a>
        </div>

        <div style="background: white; padding: var(--spacing-lg); border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
            <h3 style="margin-bottom: var(--spacing-md);">{{ $product->name }}</h3>
            <p style="color: var(--color-text-light); margin-bottom: 0;">
                <strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} đ / {{ $product->unit }}
            </p>
        </div>

        <!-- Upload Form -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: var(--spacing-lg); border-radius: 12px; margin-bottom: var(--spacing-lg);">
            <h3 style="margin-top: 0; color: white;">📤 Upload ảnh sản phẩm</h3>
            
            <form id="uploadForm" enctype="multipart/form-data" style="margin-bottom: var(--spacing-md);">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr auto auto; gap: var(--spacing-sm); align-items: end;">
                    <div>
                        <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500;">Chọn ảnh</label>
                        <input type="file" id="imageInput" name="image" accept="image/*" style="width: 100%; padding: var(--spacing-sm); border: 2px solid white; border-radius: 6px; background: rgba(255,255,255,0.1); color: white;">
                    </div>
                    <label style="display: flex; align-items: center; gap: var(--spacing-xs); background: rgba(255,255,255,0.2); padding: var(--spacing-sm) var(--spacing-md); border-radius: 6px; cursor: pointer;">
                        <input type="checkbox" id="isPrimary" name="is_primary"> Ảnh chính
                    </label>
                    <button type="submit" class="btn" style="background: white; color: #667eea; font-weight: 600; padding: var(--spacing-sm) var(--spacing-lg);">Upload</button>
                </div>
                <small style="display: block; margin-top: var(--spacing-xs); opacity: 0.9;">Max 5MB • Định dạng: JPG, PNG, GIF, WebP</small>
            </form>

            <!-- Bulk Upload -->
            <details style="cursor: pointer;">
                <summary style="font-weight: 500; padding: var(--spacing-sm); background: rgba(255,255,255,0.1); border-radius: 6px; margin-top: var(--spacing-md);">
                    📁 Upload nhiều ảnh cùng lúc
                </summary>
                <div style="padding: var(--spacing-md); background: rgba(0,0,0,0.1); border-radius: 6px; margin-top: var(--spacing-sm);">
                    <form id="bulkUploadForm" enctype="multipart/form-data" style="margin-bottom: 0;">
                        @csrf
                        <input type="file" id="bulkImageInput" name="images[]" accept="image/*" multiple style="width: 100%; padding: var(--spacing-sm); border: 2px dashed white; border-radius: 6px; background: rgba(255,255,255,0.05); color: white; box-sizing: border-box;">
                        <button type="submit" class="btn" style="background: white; color: #667eea; font-weight: 600; width: 100%; margin-top: var(--spacing-sm);">Upload tất cả</button>
                    </form>
                </div>
            </details>
        </div>

        <!-- Progress Bar -->
        <div id="progressContainer" style="display: none; margin-bottom: var(--spacing-lg);">
            <div style="background: rgba(0,0,0,0.1); border-radius: 6px; overflow: hidden;">
                <div id="progressBar" style="height: 6px; background: linear-gradient(90deg, #667eea, #764ba2); width: 0%; transition: width 0.3s ease;"></div>
            </div>
            <small id="progressText" style="display: block; margin-top: var(--spacing-xs); color: var(--color-text-light);">Đang upload...</small>
        </div>

        <!-- Current Images -->
        <div style="background: white; padding: var(--spacing-lg); border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; margin-bottom: var(--spacing-md);">
                🖼️ Ảnh hiện tại ({{ count($images) }})
            </h3>

            @if(count($images) > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: var(--spacing-md);">
                    @foreach($images as $image)
                        <div class="image-card" style="position: relative; border-radius: 8px; overflow: hidden; background: #f5f5f5; border: 2px solid {{ $image->is_primary ? 'var(--color-secondary)' : '#ddd' }};">
                            <!-- Image -->
                            <img src="{{ asset($image->image_path) }}" alt="Product image" style="width: 100%; height: 200px; object-fit: cover; display: block;">
                            
                            <!-- Badge -->
                            @if($image->is_primary)
                                <span style="position: absolute; top: var(--spacing-xs); left: var(--spacing-xs); background: var(--color-secondary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">⭐ Ảnh chính</span>
                            @endif
                            
                            <!-- Actions -->
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); padding: var(--spacing-sm); display: flex; gap: var(--spacing-xs); justify-content: center;">
                                @if(!$image->is_primary)
                                    <button class="set-primary-btn" data-image-id="{{ $image->id }}" style="flex: 1; padding: var(--spacing-xs) var(--spacing-sm); background: var(--color-secondary); color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; font-weight: 500; transition: opacity 0.2s;">
                                        ⭐ Đặt làm ảnh chính
                                    </button>
                                @endif
                                <button class="delete-btn" data-image-id="{{ $image->id }}" style="flex: 1; padding: var(--spacing-xs) var(--spacing-sm); background: #e74c3c; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; font-weight: 500; transition: opacity 0.2s;">
                                    🗑️ Xóa
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-xl); background: #f9f9f9; border-radius: 8px; border: 2px dashed #ddd;">
                    <p style="color: var(--color-text-light); font-size: 1.1rem; margin: 0;">📤 Chưa có ảnh nào</p>
                    <small style="color: var(--color-text-light);">Hãy upload ảnh đầu tiên cho sản phẩm này</small>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .image-card img:hover {
        opacity: 0.8;
    }
    
    .delete-btn:hover, .set-primary-btn:hover {
        opacity: 0.8;
    }
    
    #uploadForm input[type="file"],
    #bulkImageInput {
        file-selector-button {
            background: white;
            color: #667eea;
            padding: var(--spacing-sm) var(--spacing-md);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            margin-right: var(--spacing-sm);
        }
    }

    /* Toast Notification Styles */
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: var(--spacing-md) var(--spacing-lg);
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 9999;
        animation: slideInRight 0.3s ease, slideOutRight 0.3s ease 2.7s;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .toast.success {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
    }

    .toast.error {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
    }

    .toast.info {
        background: linear-gradient(135deg, #3498db, #2980b9);
    }

    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
</style>

<script>
    const productId = {{ $product->id }};
    const uploadForm = document.getElementById('uploadForm');
    const bulkUploadForm = document.getElementById('bulkUploadForm');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');

    // Toast notification function
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        // Tự động xóa sau 3 giây
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // Single file upload
    uploadForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const fileInput = document.getElementById('imageInput');
        const isPrimary = document.getElementById('isPrimary').checked;
        
        if (!fileInput.files.length) {
            showToast('Vui lòng chọn ảnh', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('image', fileInput.files[0]);
        formData.append('is_primary', isPrimary ? 1 : 0);
        formData.append('_token', '{{ csrf_token() }}');

        progressContainer.style.display = 'block';
        progressBar.style.width = '30%';

        try {
            const response = await fetch(`/admin/products/${productId}/images`, {
                method: 'POST',
                body: formData,
            });

            progressBar.style.width = '100%';

            const data = await response.json();

            if (data.success) {
                showToast('Upload ảnh thành công!', 'success');
                setTimeout(() => location.reload(), 500);
            } else {
                showToast('Lỗi: ' + data.message, 'error');
            }
        } catch (error) {
            showToast('Lỗi upload: ' + error.message, 'error');
        } finally {
            progressBar.style.width = '0%';
            progressContainer.style.display = 'none';
        }
    });

    // Bulk upload
    bulkUploadForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const fileInput = document.getElementById('bulkImageInput');
        
        if (!fileInput.files.length) {
            showToast('Vui lòng chọn ảnh', 'error');
            return;
        }

        const formData = new FormData();
        Array.from(fileInput.files).forEach(file => {
            formData.append('images[]', file);
        });
        formData.append('_token', '{{ csrf_token() }}');

        progressContainer.style.display = 'block';
        progressBar.style.width = '30%';
        progressText.textContent = `Đang upload ${fileInput.files.length} ảnh...`;

        try {
            const response = await fetch(`/admin/products/${productId}/images/bulk`, {
                method: 'POST',
                body: formData,
            });

            progressBar.style.width = '100%';

            const data = await response.json();

            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 500);
            } else {
                showToast('Lỗi: ' + data.message, 'error');
            }
        } catch (error) {
            showToast('Lỗi upload: ' + error.message, 'error');
        } finally {
            progressBar.style.width = '0%';
            progressContainer.style.display = 'none';
        }
    });

    // Set as primary image
    document.querySelectorAll('.set-primary-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const imageId = e.target.dataset.imageId;
            
            try {
                const response = await fetch(`/admin/products/${productId}/images/${imageId}/primary`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                });

                const data = await response.json();

                if (data.success) {
                    showToast('✓ Đặt làm ảnh chính thành công!', 'success');
                    setTimeout(() => location.reload(), 500);
                } else {
                    showToast('Lỗi: ' + data.message, 'error');
                }
            } catch (error) {
                showToast('Lỗi: ' + error.message, 'error');
            }
        });
    });

    // Delete image
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            
            if (!confirm('Bạn có chắc chắn muốn xóa ảnh này?')) return;

            const imageId = e.target.dataset.imageId;
            const url = `/admin/products/${productId}/images/${imageId}`;
            
            console.log('Deleting image:', {productId, imageId, url});
            
            try {
                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });

                console.log('Response status:', response.status);
                const data = await response.json();
                console.log('Response data:', data);

                if (data.success) {
                    // Xoá thẻ ảnh từ DOM
                    const imageCard = e.target.closest('.image-card');
                    if (imageCard) {
                        imageCard.remove();
                    }
                    showToast('✓ Xóa ảnh thành công!', 'success');
                    setTimeout(() => location.reload(), 500);
                } else {
                    showToast('Lỗi: ' + data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Lỗi: ' + error.message, 'error');
            }
        });
    });
</script>
@endsection
