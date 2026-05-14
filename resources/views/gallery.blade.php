@extends('layouts.landing')

@section('title', 'Gallery | UNIBEN Alumni Lagos')

@section('extra_css')
<style>
    .gallery-container {
        padding: 80px 0;
    }
    .gallery-full-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }
    .gallery-card {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        height: 250px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        background: #f0f0f0;
    }
    .gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }
    .gallery-card:hover img {
        transform: scale(1.1);
    }
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(74, 14, 78, 0.9), transparent);
        padding: 30px 24px 20px;
        color: white;
        opacity: 0;
        transition: 0.3s;
    }
    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }
    .gallery-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--secondary);
        color: var(--primary);
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 50px;
        z-index: 10;
        letter-spacing: 1px;
    }
</style>
@endsection

@section('content')

<section style="background: var(--primary); color: white; padding: 100px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; font-weight: 800; margin-bottom: 16px;">Memories & Moments</h1>
        <p style="opacity: 0.8; font-size: 18px;">Capturing the heritage of the UNIBEN Alumni Lagos Branch.</p>
    </div>
</section>

<div class="gallery-container">
    <div class="container">
        <div class="gallery-full-grid">
            @forelse($images as $image)
            <div class="gallery-card">
                @if($image->category)
                    <div class="gallery-category">{{ $image->category }}</div>
                @endif
                <img src="{{ asset($image->image_url) }}" alt="{{ $image->caption }}">
                <div class="gallery-overlay">
                    <p class="font-bold text-sm">{{ $image->caption ?? 'UNIBEN Alumni Lagos' }}</p>
                </div>
            </div>
            @empty
                @php
                    $placeholders = [
                        ['img' => 'images/uniben-council.jpg', 'cap' => 'Council Meeting 2024'],
                        ['img' => 'images/102-meeting.jpeg', 'cap' => '102nd Branch Meeting'],
                        ['img' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'cap' => 'Campus Landmark'],
                        ['img' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'cap' => 'Alumni Networking'],
                        ['img' => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'cap' => 'Convocation Homecoming'],
                        ['img' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'cap' => 'Dinner & Awards'],
                    ];
                @endphp
                @foreach($placeholders as $p)
                <div class="gallery-card">
                    <img src="{{ asset($p['img']) }}" alt="">
                    <div class="gallery-overlay">{{ $p['cap'] }}</div>
                </div>
                @endforeach
            @endforelse
        </div>
    </div>
</div>

@endsection
