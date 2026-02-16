@extends('layouts.app')

@section('title', 'Ý Tưởng & Cảm Hứng')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="section-title">Ý Tưởng & Cảm Hứng</h1>
        <p class="section-subtitle">Khám phá các công trình thực tế và bài viết tư vấn</p>

        <!-- Projects -->
        <div style="margin-bottom: var(--spacing-xl);">
            <h2 style="font-size: 2rem; margin-bottom: var(--spacing-md);">Công Trình Thực Tế</h2>
            <div class="grid grid-3">
                @forelse($projects as $project)
                <a href="{{ route('inspiration.show', $project->slug) }}" class="card" style="text-decoration: none; transition: all 0.3s ease; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <div style="background: url('/images/{{ $project->featured_image ?? $project->slug . '.png' }}') center/cover; height: 300px;"></div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $project->title }}</h3>
                        <p class="card-text">{{ Str::limit($project->excerpt ?? $project->content, 150) }}</p>
                        @if($project->project_location)
                        <p style="color: var(--color-text-light); font-size: 0.9rem; margin-top: var(--spacing-xs);">
                            📍 {{ $project->project_location }}
                        </p>
                        @endif
                    </div>
                </a>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: var(--spacing-lg);">
                    <p style="color: var(--color-text-light); font-size: 1.1rem;">Chưa có dự án nào</p>
                </div>
                @endforelse
            </div>
            @if(isset($projects) && method_exists($projects, 'links'))
            <div style="margin-top: var(--spacing-md); display: flex; justify-content: center;">
                {{ $projects->links() }}
            </div>
            @endif
        </div>

        <!-- Blog Posts -->
        <div>
            <h2 style="font-size: 2rem; margin-bottom: var(--spacing-md);">Bài Viết Tư Vấn</h2>
            <div class="grid grid-3">
                @forelse($blogs as $blog)
                <a href="{{ route('inspiration.show', $blog->slug) }}" class="card" style="text-decoration: none; transition: all 0.3s ease; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <div style="background: url('/images/{{ $blog->featured_image ?? $blog->slug . '.png' }}') center/cover; height: 250px;"></div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $blog->title }}</h3>
                        <p class="card-text">{{ Str::limit($blog->excerpt ?? $blog->content, 150) }}</p>
                    </div>
                </a>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: var(--spacing-lg);">
                    <p style="color: var(--color-text-light); font-size: 1.1rem;">Chưa có bài viết nào</p>
                </div>
                @endforelse
            </div>
            @if(isset($blogs) && method_exists($blogs, 'links'))
            <div style="margin-top: var(--spacing-md); display: flex; justify-content: center;">
                {{ $blogs->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
