@extends('layouts.landing')

@section('title', 'University of Benin Alumni Association, Lagos Branch')

@section('extra_css')
<style>
    /* Hero Section */
    .hero {
        padding: 60px 0;
        background: linear-gradient(135deg, rgba(74, 14, 78, 0.05), rgba(74, 14, 78, 0.02));
        position: relative;
        overflow: hidden;
    }

    @media (min-width: 768px) {
        .hero { padding: 100px 0; }
    }

    .hero::before {
        content: '';
        position: absolute;
        bottom: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        z-index: 0;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
        align-items: center;
        position: relative;
        z-index: 1;
        text-align: center;
    }

    @media (min-width: 1024px) {
        .hero-grid { grid-template-columns: 1fr 1fr; text-align: left; gap: 60px; }
    }

    .hero-text h1 {
        font-size: 36px;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 24px;
        color: var(--primary);
    }

    @media (min-width: 768px) {
        .hero-text h1 { font-size: 56px; }
    }

    .hero-text h1 span {
        color: var(--secondary);
    }

    .hero-text p {
        font-size: 16px;
        color: var(--text-gray);
        margin-bottom: 32px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    @media (min-width: 1024px) {
        .hero-text p { font-size: 18px; margin-left: 0; }
    }

    .hero-image {
        position: relative;
    }

    .hero-image img {
        width: 100%;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border: 1px solid rgba(0,0,0,0.05);
    }

    /* Sections General */
    section { padding: 60px 0; }
    @media (min-width: 768px) {
        section { padding: 100px 0; }
    }

    .section-tag {
        color: var(--secondary);
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 12px;
        display: block;
    }
    .section-title {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 32px;
        color: var(--primary);
        line-height: 1.2;
    }
    @media (min-width: 768px) {
        .section-title { font-size: 36px; margin-bottom: 48px; }
    }

    /* Benefits Section */
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }
    .benefit-card {
        background: white;
        padding: 24px;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        transition: 0.3s;
        display: flex;
        gap: 16px;
    }
    @media (min-width: 768px) {
        .benefit-card { padding: 30px; gap: 20px; }
    }
    .benefit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(74, 14, 78, 0.05);
        border-color: var(--primary);
    }
    .benefit-icon {
        width: 44px;
        height: 44px;
        background: rgba(212, 175, 55, 0.1);
        color: var(--secondary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    @media (min-width: 768px) {
        .benefit-icon { width: 50px; height: 50px; font-size: 20px; }
    }
    .benefit-info h4 { font-size: 15px; margin-bottom: 8px; color: var(--primary); font-weight: 700; }
    .benefit-info p { font-size: 13px; color: var(--text-gray); line-height: 1.5; }

    /* Gallery Section */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(3, 150px);
        gap: 12px;
        margin-bottom: 40px;
    }

    @media (min-width: 768px) {
        .gallery-grid {
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(2, 200px);
            gap: 16px;
        }
    }
    .gallery-item {
        border-radius: 16px;
        overflow: hidden;
        position: relative;
    }
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }
    .gallery-item:hover img { transform: scale(1.1); }
    .gallery-item.large { grid-column: span 2; grid-row: span 2; }

    /* Team Section */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 20px;
    }
    @media (min-width: 768px) {
        .team-grid { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 32px; }
    }
    .team-card { text-align: center; }
    .team-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto 16px;
        overflow: hidden;
        border: 3px solid var(--secondary);
        padding: 4px;
    }
    @media (min-width: 768px) {
        .team-img { width: 150px; height: 150px; margin-bottom: 20px; }
    }
    .team-img img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .team-info h5 { font-size: 14px; font-weight: 700; color: var(--primary); margin-bottom: 4px; }
    @media (min-width: 768px) {
        .team-info h5 { font-size: 16px; }
    }
    .team-info p { font-size: 11px; color: var(--text-gray); font-weight: 500; }
    @media (min-width: 768px) {
        .team-info p { font-size: 13px; }
    }

    /* News & Events Items */
    .news-card-item {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    @media (min-width: 768px) {
        .news-card-item { margin-bottom: 30px; }
    }
    .news-card-img { height: 180px; background-size: cover; background-position: center; }
    @media (min-width: 768px) {
        .news-card-img { height: 200px; }
    }
    .news-card-body { padding: 20px; }
    @media (min-width: 768px) {
        .news-card-body { padding: 24px; }
    }

    /* Cooperative & Real Estate Section Custom Styles */
    .coop-section {
        padding: 100px 0;
        background: #fafafa;
        position: relative;
    }
    .coop-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 50px;
        align-items: center;
    }
    @media (min-width: 1024px) {
        .coop-grid {
            grid-template-columns: 1.2fr 0.8fr;
        }
    }
    .coop-text-block {
        display: flex;
        flex-direction: column;
        gap: 24px;
        text-align: left;
    }
    .coop-description {
        color: var(--text-gray);
        font-size: 16px;
        line-height: 1.8;
    }
    .coop-cards-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        margin-top: 16px;
    }
    @media (min-width: 640px) {
        .coop-cards-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    .coop-card {
        background: white;
        padding: 30px;
        border-radius: 24px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .coop-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(74, 14, 78, 0.08);
        border-color: var(--primary);
    }
    .coop-card-icon {
        width: 50px;
        height: 50px;
        background: rgba(74, 14, 78, 0.05);
        color: var(--primary);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: all 0.3s ease;
    }
    .coop-card:hover .coop-card-icon {
        background: var(--primary);
        color: white;
    }
    .coop-card-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--primary);
    }
    .coop-specs-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .coop-spec-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--text-dark);
        font-weight: 600;
    }
    .coop-spec-item i {
        color: var(--secondary);
    }
    .coop-image-container {
        position: relative;
        border-radius: 40px;
        overflow: hidden;
        box-shadow: 0 20px 45px rgba(0,0,0,0.12);
        aspect-ratio: 4/3;
    }
    .coop-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .coop-image-container:hover img {
        transform: scale(1.05);
    }
    .coop-image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(74, 14, 78, 0.9), transparent 60%);
        display: flex;
        align-items: flex-end;
        padding: 30px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .coop-image-container:hover .coop-image-overlay {
        opacity: 1;
    }
    .coop-image-text {
        color: white;
        font-weight: 800;
        font-size: 18px;
    }
    .coop-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 16px;
    }
</style>
@endsection

@section('content')

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-text">
                <span class="section-tag">University of Benin Alumni</span>
                <h1>Lagos <span>Branch</span> Portal</h1>
                <p>Welcome to the official digital hub of the University of Benin Alumni Association, Lagos Branch. <br> Connect, collaborate, and contribute to our shared excellence.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary w-full sm:w-auto justify-center">Dashboard <i class="fa-solid fa-arrow-right"></i></a>
                    @else
                        <a href="{{ route('membership') }}" class="btn btn-primary w-full sm:w-auto justify-center">View Benefits <i class="fa-solid fa-star"></i></a>
                        <a href="{{ route('signup') }}" class="btn btn-outline w-full sm:w-auto justify-center">Join Lagos Branch</a>
                    @endauth
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/uniben-council.jpg') }}" alt="UNIBEN Council">
            </div>
        </div>
    </div>
</section>

<!-- Benefits Highlight Section -->
<section id="benefits">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <span class="section-tag">Member Value</span>
            <h2 class="section-title">Why Be An Active Member?</h2>
            <p style="max-width: 700px; margin: -30px auto 40px; color: var(--text-gray);">Of course there are a whole lot to gain as an active member of the Association.</p>
        </div>
        <div class="benefits-grid">
            <!-- Benefit 1 -->
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-briefcase"></i></div>
                <div class="benefit-info">
                    <h4>Job Connection</h4>
                    <p>Meet Employers of labour and Influencers of employment at our meetings.</p>
                </div>
            </div>
            <!-- Benefit 2 -->
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-person-chalkboard"></i></div>
                <div class="benefit-info">
                    <h4>Mentorship</h4>
                    <p>Seasoned professionals mentor the younger generation to fruition for free.</p>
                </div>
            </div>
            <!-- Benefit 3 -->
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-globe"></i></div>
                <div class="benefit-info">
                    <h4>Networking</h4>
                    <p>A galaxy of old course mates, classmates, and set mates in one forum.</p>
                </div>
            </div>
            <!-- Benefit 4 -->
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                <div class="benefit-info">
                    <h4>Free Workshops/Seminar</h4>
                    <p>Professional talks on health, law, finance, insurance, and more at meetings.</p>
                </div>
            </div>
            
            <!-- Benefit 5 -->
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-heart"></i></div>
                <div class="benefit-info">
                    <h4>Robust Welfare Programme</h4>
                    <p>We are our brothers' keepers, celebrating good times and supporting in bad times.</p>
                </div>
            </div>
            <!-- Benefit 6 -->
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-school"></i></div>
                <div class="benefit-info">
                    <h4>Support for School Needs</h4>
                    <p>Assistance with transcripts and university needs via our Alumni Relations Unit.</p>
                </div>
            </div>
            <!-- Benefit 7 -->
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-link"></i></div>
                <div class="benefit-info">
                    <h4>World Wide Link</h4>
                    <p>Once you are a member of good standing, the whole world is in your pocket.</p>
                </div>
            </div>
            <!-- Benefit 8 -->
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-shop"></i></div>
                <div class="benefit-info">
                    <h4>Showcase Goods & Services</h4>
                    <p>Free platform to advertise your goods and services to our massive network.</p>
                </div>
            </div>
            <!-- Benefit 9 -->
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-landmark"></i></div>
                <div class="benefit-info">
                    <h4>Cooperative Society</h4>
                    <p>Access to UBAA Lagos Coop Society with numerous financial benefits.</p>
                </div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 50px;">
            <a href="{{ route('membership') }}" class="btn btn-primary">See All 10 Benefits & Join</a>
        </div>
    </div>
</section>

<!-- Team Section: National + Branch -->
<section id="team" style="background: var(--accent);">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <span class="section-tag">Governance</span>
            <h2 class="section-title">Leadership Hierarchy</h2>
        </div>

        <h3 style="color: var(--primary); margin-bottom: 30px; border-left: 5px solid var(--secondary); padding-left: 15px;">Lagos Branch Leadership</h3>
        <div class="team-grid">
            @php
                $roleNames = [
                    'chairman' => 'Branch Chairman',
                    'vice_chairman' => 'Vice Chairman',
                    'secretary' => 'Branch Secretary',
                    'legal' => 'Branch Legal Adviser',
                    'welfare' => 'Welfare Secretary',
                    'pro' => 'Public Relations Officer',
                    'pro_ii' => 'PRO II'
                ];
            @endphp
            @foreach($executives as $exec)
            <div class="team-card">
                <div class="team-img">
                    <img src="{{ $exec->avatar_url ? asset($exec->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($exec->name).'&background=D4AF37&color=4A0E4E' }}" alt="{{ $exec->name }}">
                </div>
                <div class="team-info">
                    <h5>{{ $exec->name }}</h5>
                    <p>{{ $roleNames[$exec->role] ?? 'Executive' }}</p>
                    @if($exec->phone)
                        <p style="font-size: 11px; color: var(--secondary); font-weight: 700;">{{ $exec->phone }}</p>
                    @endif
                </div>
            </div>
            @endforeach

            @if($executives->isEmpty())
                <div class="team-card">
                    <div class="team-img"><img src="https://ui-avatars.com/api/?name=Lagos+Exco&background=D4AF37&color=4A0E4E" alt=""></div>
                    <div class="team-info">
                        <h5>Branch Excos</h5>
                        <p>Committees & Leads</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section id="gallery">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <span class="section-tag">Memories</span>
            <h2 class="section-title">Lagos Branch Gallery</h2>
        </div>
        <div class="gallery-grid">
            @forelse($gallery as $index => $image)
            <div class="gallery-item {{ $index == 0 ? 'large' : '' }}">
                <img src="{{ asset($image->image_url) }}" alt="{{ $image->caption }}">
            </div>
            @empty
            <div class="gallery-item large"><img src="{{ asset('images/uniben-council.jpg') }}" alt=""></div>
            <div class="gallery-item"><img src="{{ asset('images/102-meeting.jpeg') }}" alt=""></div>
            <div class="gallery-item"><img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt=""></div>
            <div class="gallery-item"><img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt=""></div>
            <div class="gallery-item"><img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt=""></div>
            @endforelse
        </div>
        <div style="text-align: center;">
            <a href="{{ route('gallery') }}" class="btn btn-outline">See More Gallery <i class="fa-solid fa-images"></i></a>
        </div>
    </div>
</section>

<!-- Job Board Preview Section -->
<section id="jobs">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <span class="section-tag">Career Growth</span>
            <h2 class="section-title">Alumni Job Hub</h2>
            <p style="max-width: 700px; margin: -30px auto 40px; color: var(--text-gray);">Exclusive professional opportunities shared within our network. Hire an Alumnus or find your next breakthrough.</p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-6">
            @forelse($jobs as $job)
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-briefcase"></i></div>
                <div class="benefit-info">
                    <h4 class="flex justify-between items-center text-sm md:text-base font-bold">{{ $job->title }} <span class="text-[9px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-black uppercase">{{ $job->location }}</span></h4>
                    <p class="text-xs md:text-sm font-medium text-gray-500">{{ $job->company }} • {{ $job->salary_range ?? 'Salary Undisclosed' }}</p>
                    <a href="{{ route('jobs') }}" class="text-[10px] font-black text-primary uppercase mt-3 inline-block">View Details <i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </div>
            @empty
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-briefcase"></i></div>
                <div class="benefit-info">
                    <h4 class="flex justify-between items-center text-sm md:text-base font-bold">Senior Project Manager <span class="text-[9px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-black uppercase">Remote</span></h4>
                    <p class="text-xs md:text-sm font-medium text-gray-500">Techno-Link Solutions • ₦800k - 1.2M / mo</p>
                    <a href="{{ route('jobs') }}" class="text-[10px] font-black text-primary uppercase mt-3 inline-block">View Details <i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-code"></i></div>
                <div class="benefit-info">
                    <h4 class="flex justify-between items-center text-sm md:text-base font-bold">Fullstack Engineer <span class="text-[9px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-black uppercase">Lagos</span></h4>
                    <p class="text-xs md:text-sm font-medium text-gray-500">FinTech Lab • Competitive Salary</p>
                    <a href="{{ route('jobs') }}" class="text-[10px] font-black text-primary uppercase mt-3 inline-block">View Details <i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </div>
            @endforelse
        </div>
        <div style="text-align: center; margin-top: 50px;">
            <a href="{{ route('jobs') }}" class="btn btn-primary">Browse All Opportunities</a>
        </div>
    </div>
</section>

<!-- Heritage Shop Showcase -->
<section id="shop" style="background: var(--accent);">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <span class="section-tag">Collectibles</span>
            <h2 class="section-title">The Heritage Collection</h2>
            <p style="max-width: 700px; margin: -30px auto 40px; color: var(--text-gray);">Rock the UNIBEN pride. Official alumni apparel, keepsakes, and heritage items available for order.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px;">
            @forelse($products as $product)
            <a href="{{ route('shop') }}" style="background: white; border-radius: 20px; overflow: hidden; border: 1px solid #f0f0f0; display: flex; flex-direction: column; text-decoration: none; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 15px 30px rgba(74,14,78,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
                <div style="height: 200px; overflow: hidden; position: relative; background: #f9fafb; display: flex; align-items: center; justify-content: center;">
                    @if($product->image_url)
                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                    @else
                        <i class="fas fa-box-open" style="font-size: 2.5rem; color: #e5e7eb;"></i>
                    @endif
                    @if($product->original_price && $product->original_price > $product->price)
                        @php $discount = round((($product->original_price - $product->price) / $product->original_price) * 100); @endphp
                        <span style="position: absolute; top: 12px; left: 12px; background: #ef4444; color: white; font-size: 9px; padding: 2px 8px; border-radius: 4px; font-weight: 800;">-{{ $discount }}%</span>
                    @endif
                    @if($product->badge)
                        <span style="position: absolute; top: 12px; right: 12px; background: var(--secondary); color: var(--primary); font-size: 9px; padding: 2px 8px; border-radius: 4px; font-weight: 800;">{{ $product->badge }}</span>
                    @endif
                </div>
                <div style="padding: 16px; display: flex; flex-direction: column; flex-grow: 1;">
                    <span style="font-size: 9px; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 6px;">{{ $product->category }}</span>
                    <h4 style="font-size: 13px; font-weight: 700; color: #1f2937; margin-bottom: 12px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1;">{{ $product->title }}</h4>
                    <div style="display: flex; align-items: center; gap: 8px; margin-top: auto;">
                        @if($product->original_price)
                            <span style="font-size: 11px; color: #d1d5db; text-decoration: line-through;">₦{{ number_format($product->original_price) }}</span>
                        @endif
                        <span style="font-size: 16px; font-weight: 900; color: var(--primary);">₦{{ number_format($product->price) }}</span>
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; padding: 60px; text-align: center;">
                <i class="fas fa-store" style="font-size: 2.5rem; color: #e5e7eb; display: block; margin-bottom: 16px;"></i>
                <p style="color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; font-size: 12px;">Heritage items coming soon</p>
            </div>
            @endforelse
        </div>

        <div style="text-align: center; margin-top: 50px;">
            <a href="{{ route('shop') }}" class="btn btn-outline">Visit the Alum-Shop</a>
        </div>
    </div>
</section>

<!-- Cooperative & Real Estate Section -->
<section id="cooperative" class="coop-section">
    <div class="container">
        <div class="coop-grid">
            <div class="coop-text-block">
                <div>
                    <span class="section-tag">Collective Wealth</span>
                    <h2 class="section-title" style="margin-bottom: 24px;">{{ $cooperative->title ?? 'Uniben Alumni Cooperative Estate' }}</h2>
                    <p class="coop-description">
                        {{ $cooperative->description ?? 'Secure your family’s future with the premier residential estate scheme by the UNIBEN Alumni Lagos Cooperative Society. Located in a high-growth corridor at Idi-Obi, Arapagi, Bogije axis of Lagos State, this planned community offers comfort, safety, and shared prosperity.' }}
                    </p>
                </div>

                <div class="coop-cards-grid">
                    <!-- Card 1: Estate Details -->
                    <div class="coop-card">
                        <div class="coop-card-icon"><i class="fa-solid fa-house-circle-check"></i></div>
                        <h4 class="coop-card-title">Cooperative Estate Scheme</h4>
                        <ul class="coop-specs-list">
                            <li class="coop-spec-item"><i class="fa-solid fa-map-pin"></i> Idi-Obi, Arapagi, Bogije axis, Lagos</li>
                            <li class="coop-spec-item"><i class="fa-solid fa-maximize"></i> 500sqm per plot size</li>
                            <li class="coop-spec-item"><i class="fa-solid fa-shield-halved"></i> Global C of O & Deed included</li>
                            <li class="coop-spec-item"><i class="fa-solid fa-tags"></i> ₦10,000,000 per plot</li>
                        </ul>
                    </div>
                    
                    <!-- Card 2: Investment Features -->
                    <div class="coop-card">
                        <div class="coop-card-icon"><i class="fa-solid fa-coins"></i></div>
                        <h4 class="coop-card-title">Payment & Accessibility</h4>
                        <ul class="coop-specs-list">
                            <li class="coop-spec-item"><i class="fa-solid fa-calendar-days"></i> 3-6 Months installments</li>
                            <li class="coop-spec-item"><i class="fa-solid fa-credit-card"></i> 30% initial deposit</li>
                            <li class="coop-spec-item"><i class="fa-solid fa-road"></i> Direct Sangotedo link road</li>
                            <li class="coop-spec-item"><i class="fa-solid fa-ship"></i> Waterways ferry transport access</li>
                        </ul>
                    </div>
                </div>

                <div class="coop-actions">
                    <a href="{{ route('cooperative') }}" class="btn btn-primary px-10">Learn More <i class="fa-solid fa-users-gear"></i></a>
                    <a href="{{ $cooperative->application_link ?? route('cooperative') }}" class="btn btn-outline">Join Society / Apply</a>
                </div>
            </div>

            <div class="coop-image-container">
                <img src="{{ $cooperative && $cooperative->image_url ? asset($cooperative->image_url) : asset('images/land.jpeg') }}" alt="Cooperative Estate">
                <div class="coop-image-overlay">
                    <p class="coop-image-text">{{ $cooperative->title ?? 'Uniben Alumni Cooperative Estate' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Donation / Project Support -->
<section id="donate" class="py-16 md:py-24">
    <div class="container">
        <div class="bg-primary rounded-[40px] px-6 py-16 md:p-20 text-center text-white relative overflow-hidden">
            <div class="relative z-10">
                <span class="text-secondary font-black text-xs uppercase tracking-widest">Give Back</span>
                <h2 class="text-3xl md:text-5xl font-black mt-4 mb-6 leading-tight">Support Branch Projects</h2>
                <p class="max-w-xl mx-auto mb-10 opacity-80 text-base md:text-lg font-medium">Your donations fuel our student scholarships, infrastructure support for our Alma Mater, and welfare funds for alumni in need.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('donate') }}" class="btn btn-secondary px-10 py-4 justify-center">Donate Now <i class="fa-solid fa-heart"></i></a>
                    <a href="{{ route('home') }}#contact" class="btn btn-outline border-white text-white hover:bg-white hover:text-primary px-10 py-4 justify-center">Speak with us</a>
                </div>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-secondary opacity-10 rounded-full blur-3xl"></div>
        </div>
    </div>
</section>

<!-- News & Events Section -->
<section id="news" style="background: var(--accent);">
    <div class="container">
        <div class="grid lg:grid-cols-3 gap-12 lg:gap-20">
            <div class="lg:col-span-2 space-y-8">
                <span class="section-tag">Updates</span>
                <h2 class="section-title">Latest Branch News</h2>
                @forelse($news as $item)
                    <a href="{{ route('news.show', $item->slug ?? $item->id) }}" class="news-card-link" style="text-decoration: none; display: block;">
                        <div class="news-card-item">
                            <div class="news-card-img" style="background-image: url('{{ $item->image_url ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}')"></div>
                            <div class="news-card-body">
                                <span style="font-size: 12px; color: var(--secondary); font-weight: 700;">{{ $item->category ?? 'BRANCH NEWS' }}</span>
                                <h4 style="margin: 8px 0; color: var(--primary);">{{ $item->title }}</h4>
                                <p style="font-size: 14px; color: var(--text-gray);">{{ Str::limit(strip_tags($item->content ?? ''), 120) }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p>No branch news at the moment.</p>
                @endforelse
            </div>
            <div id="events">
                <span class="section-tag">Calendar</span>
                <h2 class="section-title">Lagos Programs</h2>
                @forelse($events as $event)
                    <div style="background: white; padding: 20px; border-radius: 16px; margin-bottom: 16px; display: flex; gap: 20px; align-items: center; border: 1px solid rgba(0,0,0,0.03);">
                        <div style="background: var(--primary); color: white; padding: 10px; border-radius: 10px; text-align: center; min-width: 60px;">
                            <div style="font-size: 10px; opacity: 0.8;">{{ $event->event_month }}</div>
                            <div style="font-size: 18px; font-weight: 800;">{{ $event->event_day }}</div>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="font-size: 14px; color: var(--primary);">{{ $event->title }}</h4>
                            <p style="font-size: 11px; color: var(--text-gray);"><i class="fa-solid fa-clock"></i> {{ $event->location_name }}</p>
                        </div>
                        <div>
                            <a href="{{ route('events.detail', $event->id) }}" class="hover-bg-primary hover-text-white" style="font-size: 11px; font-weight: 800; color: var(--primary); text-decoration: none; border: 1px solid var(--primary); padding: 6px 12px; border-radius: 6px; transition: 0.3s; display: inline-block;">Details</a>
                        </div>
                    </div>
                @empty
                    <p>No scheduled programs.</p>
                @endforelse
                <a href="{{ route('events') }}" class="btn btn-outline" style="width: 100%; justify-content: center; margin-top: 20px;">Full Calendar</a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-20" style="background: white;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <span class="section-tag">Get In Touch</span>
            <h2 class="section-title">Contact Lagos Branch</h2>
            <p style="max-width: 700px; margin: -30px auto 40px; color: var(--text-gray);">Have questions about membership, events, or our cooperative? Reach out to us today.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-10">
            <div class="text-center p-8 rounded-[32px] bg-gray-50 border border-gray-100 hover:shadow-xl transition-all group">
                <div class="w-16 h-16 bg-primary/5 rounded-2xl flex items-center justify-center text-primary text-2xl mx-auto mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h4 class="font-bold text-primary mb-2">Branch Office/Secretariat</h4>
                <p class="text-sm text-gray-500">3, Williams Carew Street,Off Sylvia Crecent <br> Anthony, Lagos State.</p>
            </div>

            <div class="text-center p-8 rounded-[32px] bg-gray-50 border border-gray-100 hover:shadow-xl transition-all group">
                <div class="w-16 h-16 bg-secondary/5 rounded-2xl flex items-center justify-center text-secondary text-2xl mx-auto mb-6 group-hover:bg-secondary group-hover:text-white transition-colors">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <h4 class="font-bold text-primary mb-2">Call Support</h4>
                <p class="text-sm text-gray-500">08098728010 <br> 07088686970</p>
            </div>

            <div class="text-center p-8 rounded-[32px] bg-gray-50 border border-gray-100 hover:shadow-xl transition-all group">
                <div class="w-16 h-16 bg-primary/5 rounded-2xl flex items-center justify-center text-primary text-2xl mx-auto mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <h4 class="font-bold text-primary mb-2">Email Address</h4>
                <p class="text-sm text-gray-500">ubaalagos@yahoo.com <br> support@ubaalagos.org</p>
            </div>
        </div>
    </div>
</section>

@endsection
