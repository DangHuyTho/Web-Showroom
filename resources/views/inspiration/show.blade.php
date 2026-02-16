@extends('layouts.app')

@section('title', $post->title)

@section('content')
<section class="section">
    <div class="container" style="max-width: 1000px;">

        <article>
            @if($post->featured_image || file_exists(public_path('images/' . $post->slug . '.png')))
            <div style="background: url('/images/{{ $post->featured_image ?? $post->slug . '.png' }}') center/cover; height: 500px; margin-bottom: var(--spacing-md); border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"></div>
            @endif

            <h1 style="font-size: 3rem; margin-bottom: var(--spacing-sm);">{{ $post->title }}</h1>
            
            @if($post->project_location || $post->project_date)
            <div style="display: flex; gap: var(--spacing-md); margin-bottom: var(--spacing-md); color: var(--color-text-light);">
                @if($post->project_location)
                <span>📍 {{ $post->project_location }}</span>
                @endif
                @if($post->project_date)
                <span>📅 {{ $post->project_date->format('d/m/Y') }}</span>
                @endif
            </div>
            @endif

            @if($post->excerpt)
            <p style="font-size: 1.25rem; color: var(--color-text-light); margin-bottom: var(--spacing-md); line-height: 1.8;">
                {{ $post->excerpt }}
            </p>
            @endif

            @if($post->content)
            <div style="line-height: 1.8; font-size: 1.1rem; color: var(--color-text);">
                {!! $post->content !!}
            </div>
            @endif
        </article>

        <!-- Related Posts -->
        @if(isset($relatedPosts) && $relatedPosts->count() > 0)
        <div style="border-top: 1px solid var(--color-border); padding-top: var(--spacing-md); margin-top: var(--spacing-xl);">
            <h2 style="font-size: 1.5rem; margin-bottom: var(--spacing-md);">Bài Viết Liên Quan</h2>
            <div class="grid grid-3">
                @foreach($relatedPosts as $related)
                <a href="{{ route('inspiration.show', $related->slug) }}" class="card" style="text-decoration: none; transition: all 0.3s ease; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <div style="background: url('/images/{{ $related->featured_image ?? $related->slug . '.png' }}') center/cover; height: 200px;"></div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $related->title }}</h3>
                        <p class="card-text">{{ Str::limit($related->excerpt ?? $related->content, 100) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
