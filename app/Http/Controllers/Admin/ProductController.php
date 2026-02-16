<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category']);
        
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }
        
        $products = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        
        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }
    
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        
        return view('admin.products.create', compact('categories', 'brands'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'unit' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'surface_type' => 'nullable|string|max:255',
            'water_absorption' => 'nullable|string|max:255',
            'hardness' => 'nullable|string|max:255',
            'glaze_technology' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'applications' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        
        Product::create($validated);
        
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được tạo thành công.');
    }
    
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }
    
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $product->id . '|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'unit' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'surface_type' => 'nullable|string|max:255',
            'water_absorption' => 'nullable|string|max:255',
            'hardness' => 'nullable|string|max:255',
            'glaze_technology' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'applications' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        
        $product->update($validated);
        
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }
    
    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa thành công.');
    }
    
    public function toggleActive(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return redirect()->back()->with('success', 'Trạng thái sản phẩm đã được cập nhật.');
    }
    
    public function toggleFeatured(Product $product)
    {
        $product->is_featured = !$product->is_featured;
        $product->save();

        return redirect()->back()->with('success', ($product->is_featured ? 'Sản phẩm đã được đánh dấu nổi bật.' : 'Sản phẩm đã bỏ nổi bật.'));
    }
}
