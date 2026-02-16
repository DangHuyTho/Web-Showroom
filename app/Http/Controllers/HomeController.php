<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\InspirationPost;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $brands = Brand::where('is_active', true)->orderBy('sort_order')->get();
        $roomCategories = Category::where('type', 'room')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with(['brand', 'category', 'primaryImage'])
            ->orderBy('sort_order')
            ->limit(8)
            ->get();
        $featuredProjects = InspirationPost::where('is_featured', true)
            ->where('is_active', true)
            ->where('post_type', 'project')
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('home', compact('brands', 'roomCategories', 'featuredProducts', 'featuredProjects'));
    }
}
