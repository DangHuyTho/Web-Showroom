<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Helpers\ProductFilterHelper;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with(['brand', 'category', 'images']);

        if ($request->has('brand') && $request->brand != '') {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('space') && $request->space != '') {
            $query->whereIn('id', function($subQuery) use ($request) {
                $subQuery->select('product_id')
                    ->from('product_space')
                    ->where('space_type', $request->space);
            });
        }

        if ($request->has('size') && $request->size != '') {
            $query->where('size', $request->size);
        }

        if ($request->has('surface_type') && $request->surface_type != '') {
            $query->where('surface_type', $request->surface_type);
        }

        if ($request->has('product_type') && $request->product_type != '') {
            $query->where('product_type', $request->product_type);
        }

        if ($request->has('product_category') && $request->product_category != '') {
            $query->where('product_category', $request->product_category);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('sort_order')->paginate(24)->appends(request()->query());
        $brands = Brand::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::where('type', 'product')->where('is_active', true)->orderBy('sort_order')->get();
        
        // Get unique sizes and surface types from products
        $sizes = Product::where('is_active', true)->whereNotNull('size')->distinct()->pluck('size')->sort()->values();
        $surfaceTypes = Product::where('is_active', true)->whereNotNull('surface_type')->distinct()->pluck('surface_type')->sort()->values();

        // Define spaces
        $spaces = [
            'living_room' => 'Phòng Khách',
            'kitchen' => 'Nhà Bếp',
            'bathroom' => 'Phòng Tắm',
            'outdoor' => 'Ngoài Thất'
        ];

        // Get filter config for brands
        $filterConfig = ProductFilterHelper::getBrandFilterConfig();

        return view('products.index', compact('products', 'brands', 'categories', 'sizes', 'surfaceTypes', 'spaces', 'filterConfig'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['brand', 'category', 'images'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with(['brand', 'images'])
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function byBrand($brandSlug)
    {
        // Verify brand exists
        $brand = Brand::where('slug', $brandSlug)->where('is_active', true)->firstOrFail();
        
        // Redirect to products index with brand filter
        return redirect()->route('products.index', ['brand' => $brandSlug]);
    }
}
