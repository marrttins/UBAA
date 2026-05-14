@extends('layouts.landing')

@section('title', 'Alumni News & Updates')

@section('content')
<!-- Hero Section -->
<section style="background: var(--primary); padding: 100px 0 60px; color: white; text-align: center;">
    <div class="container">
        <span class="section-tag" style="background: rgba(255,255,255,0.1); color: var(--secondary);">Stay Informed</span>
        <h1 style="font-size: 3rem; font-weight: 900; margin-bottom: 20px;">Lagos Branch Newsroom</h1>
        <p style="max-width: 700px; margin: 0 auto; opacity: 0.8; font-size: 1.1rem;">Latest updates, success stories, and official announcements from the Uniben Alumni Association, Lagos Branch.</p>
    </div>
</section>

<!-- News Grid -->
<section style="padding: 80px 0; background: #fdfdfd;">
    <div class="container">
        @if($news->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 40px;">
            @foreach($news as $article)
            <div class="news-card" style="background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s ease; border: 1px solid #f0f0f0;">
                <div style="height: 240px; overflow: hidden; position: relative;">
                    <img src="{{ $article->image_url ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <span style="position: absolute; top: 20px; left: 20px; background: var(--secondary); color: var(--primary); padding: 6px 15px; border-radius: 50px; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px;">
                        {{ $article->category ?? 'General' }}
                    </span>
                </div>
                <div style="padding: 30px;">
                    <p style="font-size: 12px; color: #999; margin-bottom: 10px; font-weight: 600;">
                        <i class="far fa-calendar-alt mr-2"></i> {{ $article->created_at->format('M d, Y') }}
                    </p>
                    <h3 style="font-size: 1.4rem; font-weight: 800; line-height: 1.3; margin-bottom: 15px; color: #333;">
                        {{ $article->title }}
                    </h3>
                    <p style="color: #666; font-size: 0.95rem; line-height: 1.6; margin-bottom: 25px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $article->summary ?? Str::limit(strip_tags($article->content), 120) }}
                    </p>
                    <a href="{{ route('news.show', $article->slug ?? $article->id) }}" style="color: var(--primary); font-weight: 800; font-size: 0.9rem; text-decoration: none; display: flex; items-center: center; gap: 8px;" class="hover-move">
                        Read Full Story <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 60px; display: flex; justify-content: center;">
            {{ $news->links() }}
        </div>
        @else
        <div style="text-align: center; padding: 100px 0;">
            <i class="fas fa-newspaper" style="font-size: 4rem; color: #eee; margin-bottom: 20px;"></i>
            <h3 style="color: #ccc;">No news articles published yet.</h3>
        </div>
        @endif
    </div>
</section>

<style>
    .news-card:hover { transform: translateY(-10px); }
    .hover-move i { transition: transform 0.3s ease; }
    .hover-move:hover i { transform: translateX(5px); }
</style>
@endsection
