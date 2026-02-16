<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();
        
        $recentProducts = Product::with('category', 'brand')
                                 ->orderBy('created_at', 'desc')
                                 ->take(5)
                                 ->get();
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'totalCategories',
            'totalBrands',
            'recentProducts'
        ));
    }
}
