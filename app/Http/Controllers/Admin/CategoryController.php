<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with('parent');
        
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $categories = $query->orderBy('sort_order', 'asc')->paginate(20);
        
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        
        return view('admin.categories.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug|max:255',
            'type' => 'required|string|in:product,inspiration',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        
        Category::create($validated);
        
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được tạo thành công.');
    }
    
    public function edit(Category $category)
    {
        $categories = Category::where('is_active', true)
                             ->where('id', '!=', $category->id)
                             ->get();
        
        return view('admin.categories.edit', compact('category', 'categories'));
    }
    
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $category->id . '|max:255',
            'type' => 'required|string|in:product,inspiration',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        
        $category->update($validated);
        
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật thành công.');
    }
    
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->exists()) {
            return redirect()->back()->with('error', 'Không thể xóa danh mục vì nó có sản phẩm.');
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xóa thành công.');
    }
    
    public function toggleActive(Category $category)
    {
        $category->is_active = !$category->is_active;
        $category->save();
        
        return redirect()->back()->with('success', 'Trạng thái danh mục đã được cập nhật.');
    }
}
