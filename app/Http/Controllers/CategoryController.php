<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with(['brand', 'images'])
            ->orderBy('sort_order')
            ->paginate(24);

        $subCategories = Category::where('parent_id', $category->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('categories.show', compact('category', 'products', 'subCategories'));
    }
}
