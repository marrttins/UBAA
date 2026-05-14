@extends('layouts.landing')

@section('title', $article->title)

@section('content')
<!-- Single News Content -->
<article style="padding-top: 120px; background: white;">
    <div class="container" style="max-width: 900px;">
        <div style="text-align: center; margin-bottom: 50px;">
            <span style="color: var(--primary); font-weight: 800; text-transform: uppercase; font-size: 12px; letter-spacing: 2px;">{{ $article->category ?? 'General News' }}</span>
            <h1 style="font-size: 3rem; font-weight: 900; line-height: 1.1; margin: 20px 0; color: #1a1a1a;">{{ $article->title }}</h1>
            <div style="display: flex; align-items: center; justify-content: center; gap: 20px; color: #888; font-weight: 600; font-size: 14px;">
                <span><i class="fas fa-user-circle mr-2"></i> {{ $article->author ?? 'Admin' }}</span>
                <span><i class="far fa-calendar-alt mr-2"></i> {{ $article->created_at->format('M d, Y') }}</span>
            </div>
        </div>

        @if($article->image_url)
        <div style="border-radius: 32px; overflow: hidden; margin-bottom: 60px; box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
            <img src="{{ asset($article->image_url) }}" alt="{{ $article->title }}" style="width: 100%; height: auto; display: block;">
        </div>
        @endif

        <div class="article-body" style="font-size: 1.2rem; line-height: 1.8; color: #444;">
            {!! nl2br(e($article->content)) !!}
        </div>

        <div style="margin-top: 80px; padding-top: 40px; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; gap: 15px;">
                <span style="font-weight: 700; color: #1a1a1a;">Share this story:</span>
                <a href="#" class="share-btn"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="share-btn"><i class="fab fa-twitter"></i></a>
                <a href="#" class="share-btn"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <a href="{{ route('news.index') }}" style="color: var(--primary); font-weight: 800; text-decoration: none;">
                <i class="fas fa-th-large mr-2"></i> All News
            </a>
        </div>
    </div>
</article>

<!-- Recent News Section -->
<section style="padding: 100px 0; background: #fafafa;">
    <div class="container">
        <h2 style="font-size: 2rem; font-weight: 900; margin-bottom: 50px; text-align: center;">More Stories</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
            @foreach($recent_news as $recent)
            <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                <div style="height: 180px;">
                    <img src="{{ $recent->image_url ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" alt="{{ $recent->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="padding: 20px;">
                    <h4 style="font-weight: 800; margin-bottom: 10px;"><a href="{{ route('news.show', $recent->slug ?? $recent->id) }}" style="color: inherit; text-decoration: none;">{{ Str::limit($recent->title, 60) }}</a></h4>
                    <p style="font-size: 12px; color: #999;">{{ $recent->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .share-btn {
        width: 35px;
        height: 35px;
        background: #f5f5f5;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #666;
        transition: all 0.3s ease;
    }
    .share-btn:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-3px);
    }
    .article-body p { margin-bottom: 25px; }
</style>
@endsection
