<?php

namespace App\Http\Controllers;

use App\Models\InspirationPost;
use Illuminate\Http\Request;

class InspirationController extends Controller
{
    public function index()
    {
        $projects = InspirationPost::where('post_type', 'project')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        $blogs = InspirationPost::where('post_type', 'blog')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('inspiration.index', compact('projects', 'blogs'));
    }

    public function show($slug)
    {
        $post = InspirationPost::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedPosts = InspirationPost::where('post_type', $post->post_type)
            ->where('id', '!=', $post->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('inspiration.show', compact('post', 'relatedPosts'));
    }
}
