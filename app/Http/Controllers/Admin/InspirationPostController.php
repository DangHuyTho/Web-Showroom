<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InspirationPost;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InspirationPostController extends Controller
{
    /**
     * Display all inspiration posts
     */
    public function index(Request $request)
    {
        $query = InspirationPost::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
        }

        // Filter by type
        if ($request->filled('post_type')) {
            $query->where('post_type', $request->input('post_type'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($status === 'featured') {
                $query->where('is_featured', true);
            }
        }

        $posts = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.inspiration-posts.index', compact('posts'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        $types = ['inspiration', 'case-study', 'blog', 'project'];

        return view('admin.inspiration-posts.create', compact('products', 'types'));
    }

    /**
     * Store new inspiration post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'post_type' => 'required|in:inspiration,case-study,blog,project',
            'project_location' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'related_products' => 'nullable|array',
            'related_products.*' => 'integer|exists:products,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('inspiration-posts', 'public');
            $validated['featured_image'] = $path;
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);

        // Ensure unique slug
        $count = InspirationPost::where('slug', $validated['slug'])->count();
        if ($count > 0) {
            $validated['slug'] = $validated['slug'] . '-' . time();
        }

        $post = InspirationPost::create($validated);

        return redirect()->route('admin.inspiration-posts.show', $post->id)
                        ->with('success', 'Bài viết cảm hứng đã được tạo thành công!');
    }

    /**
     * Show inspiration post
     */
    public function show(InspirationPost $inspiration_post)
    {
        return view('admin.inspiration-posts.show', compact('inspiration_post'));
    }

    /**
     * Show edit form
     */
    public function edit(InspirationPost $inspiration_post)
    {
        $post = $inspiration_post;
        $products = Product::where('is_active', true)->orderBy('name')->get();
        $types = ['inspiration', 'case-study', 'blog', 'project'];

        return view('admin.inspiration-posts.edit', compact('post', 'products', 'types'));
    }

    /**
     * Update inspiration post
     */
    public function update(Request $request, InspirationPost $inspiration_post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'post_type' => 'required|in:inspiration,case-study,blog,project',
            'project_location' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'related_products' => 'nullable|array',
            'related_products.*' => 'integer|exists:products,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($inspiration_post->featured_image && file_exists(storage_path('app/public/' . $inspiration_post->featured_image))) {
                unlink(storage_path('app/public/' . $inspiration_post->featured_image));
            }
            $path = $request->file('featured_image')->store('inspiration-posts', 'public');
            $validated['featured_image'] = $path;
        }

        // Update slug if title changed
        if ($validated['title'] !== $inspiration_post->title) {
            $validated['slug'] = Str::slug($validated['title']);
            $count = InspirationPost::where('slug', $validated['slug'])->where('id', '!=', $inspiration_post->id)->count();
            if ($count > 0) {
                $validated['slug'] = $validated['slug'] . '-' . time();
            }
        }

        $inspiration_post->update($validated);

        return redirect()->route('admin.inspiration-posts.show', $inspiration_post->id)
                        ->with('success', 'Bài viết cảm hứng đã được cập nhật thành công!');
    }

    /**
     * Delete inspiration post
     */
    public function destroy(InspirationPost $inspiration_post)
    {
        // Delete image if exists
        if ($inspiration_post->featured_image && file_exists(storage_path('app/public/' . $inspiration_post->featured_image))) {
            unlink(storage_path('app/public/' . $inspiration_post->featured_image));
        }

        $inspiration_post->delete();

        return redirect()->route('admin.inspiration-posts.index')
                        ->with('success', 'Bài viết cảm hứng đã được xóa thành công!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(InspirationPost $inspiration_post)
    {
        $inspiration_post->update(['is_active' => !$inspiration_post->is_active]);

        return redirect()->back()->with('success', 'Trạng thái đã được cập nhật!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(InspirationPost $inspiration_post)
    {
        $inspiration_post->update(['is_featured' => !$inspiration_post->is_featured]);

        return redirect()->back()->with('success', 'Trạng thái nổi bật đã được cập nhật!');
    }
}
