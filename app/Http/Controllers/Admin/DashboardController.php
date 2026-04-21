<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\EmailVerification;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();
        
        // Pending verifications
        $pendingVerifications = EmailVerification::where('is_admin_verification', true)
                                                  ->where('expires_at', '>=', now())
                                                  ->count();
        
        $recentProducts = Product::with('category', 'brand')
                                 ->orderBy('created_at', 'desc')
                                 ->take(5)
                                 ->get();
        
        // Recent pending verifications
        $recentVerifications = EmailVerification::where('is_admin_verification', true)
                                               ->orderBy('created_at', 'desc')
                                               ->take(5)
                                               ->get();
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'totalCategories',
            'totalBrands',
            'pendingVerifications',
            'recentProducts',
            'recentVerifications'
        ));
    }
}
