<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Show image management page for a product
     */
    public function edit($productId)
    {
        $product = Product::findOrFail($productId);
        $images = $product->images()->get();

        return view('admin.products.images', compact('product', 'images'));
    }

    /**
     * Upload product image
     */
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
            'is_primary' => 'sometimes|boolean',
        ]);

        try {
            // Tạo tên file unique
            $file = $request->file('image');
            $filename = $product->slug . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Lưu file vào public/images/products
            $file->move(public_path('images/products'), $filename);

            // Nếu đánh dấu là primary, set các image khác thành false
            if ($request->has('is_primary') && $request->is_primary) {
                $product->images()->update(['is_primary' => false]);
            }

            // Lưu record vào database
            $productImage = ProductImage::create([
                'product_id' => $productId,
                'image_path' => '/images/products/' . $filename,
                'is_primary' => $request->has('is_primary') && $request->is_primary ? true : false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Upload ảnh thành công!',
                'image_id' => $productImage->id,
                'image_path' => $productImage->image_path,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi upload: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Set image as primary
     */
    public function setPrimary($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = ProductImage::findOrFail($imageId);

        // Kiểm tra image thuộc về product này
        if ($image->product_id !== $productId) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: Ảnh không thuộc sản phẩm này',
            ], 403);
        }

        // Set image này là primary
        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật ảnh chính!',
        ]);
    }

    /**
     * Delete product image
     */
    public function destroy($productId, $image)
    {
        $product = Product::findOrFail($productId);
        
        // Nếu $image là ProductImage object (từ implicit model binding)
        if (!($image instanceof ProductImage)) {
            $image = ProductImage::findOrFail($image);
        }

        // Kiểm tra image thuộc về product này
        if ($image->product_id !== (int)$productId) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: Ảnh không thuộc sản phẩm này',
            ], 403);
        }

        try {
            // Xóa file
            $filepath = public_path('images/products/' . basename($image->image_path));
            if (file_exists($filepath)) {
                unlink($filepath);
            }

            // Xóa record
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa ảnh!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi xóa ảnh: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk upload images
     */
    public function bulkUpload(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $uploadedCount = 0;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                try {
                    $filename = $product->slug . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/products'), $filename);

                    ProductImage::create([
                        'product_id' => $productId,
                        'image_path' => '/images/products/' . $filename,
                        'is_primary' => $uploadedCount === 0, // Set ảnh đầu tiên làm primary
                    ]);

                    $uploadedCount++;
                } catch (\Exception $e) {
                    \Log::error('Upload image error: ' . $e->getMessage());
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Upload $uploadedCount ảnh thành công!",
            'count' => $uploadedCount,
        ]);
    }
}
