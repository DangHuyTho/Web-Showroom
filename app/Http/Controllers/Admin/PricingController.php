<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    /**
     * Show product pricing management
     */
    public function index(Request $request)
    {
        $query = Product::with('category', 'brand');

        // Search by name or SKU
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by brand
        if ($request->has('brand_id') && $request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        $products = $query->paginate(20);

        return view('admin.pricing.index', compact('products'));
    }

    /**
     * Show edit pricing form
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.pricing.edit', compact('product'));
    }

    /**
     * Update product pricing
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after:sale_start_date',
        ], [
            'price.required' => 'Vui lòng nhập giá bán',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá không thể âm',
            'sale_price.numeric' => 'Giá khuyến mãi phải là số',
            'sale_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc',
            'sale_end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
        ]);

        $product = Product::findOrFail($id);
        
        $product->update([
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'] ?? null,
            'sale_start_date' => $validated['sale_start_date'] ?? null,
            'sale_end_date' => $validated['sale_end_date'] ?? null,
        ]);

        return redirect()->route('admin.pricing.index')
            ->with('success', 'Cập nhật giá thành công');
    }

    /**
     * Bulk price update
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array|min:1',
            'price_adjustment' => 'required|numeric',
            'adjustment_type' => 'required|in:fixed,percentage',
        ]);

        $products = Product::whereIn('id', $validated['product_ids'])->get();

        foreach ($products as $product) {
            if ($validated['adjustment_type'] === 'percentage') {
                $newPrice = $product->price * (1 + ($validated['price_adjustment'] / 100));
            } else {
                $newPrice = $product->price + $validated['price_adjustment'];
            }

            $product->update(['price' => max(0, $newPrice)]);
        }

        return redirect()->back()
            ->with('success', 'Cập nhật giá cho ' . count($products) . ' sản phẩm thành công');
    }
}
