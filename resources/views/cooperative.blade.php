@extends('layouts.landing')

@section('title', 'Cooperative Society | UNIBEN Alumni Lagos')

@section('extra_css')
<style>
    .coop-hero {
        background: linear-gradient(rgba(74, 14, 78, 0.9), rgba(74, 14, 78, 0.9)), 
                    url('{{ $setting && $setting->image_url ? asset($setting->image_url) : asset('images/land.jpeg') }}');
        background-size: cover;
        background-position: center;
        padding: 120px 0;
        color: white;
        text-align: center;
    }
    .video-modal, .apply-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.9);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .video-container {
        width: 100%;
        max-width: 900px;
        aspect-ratio: 16/9;
        background: black;
        position: relative;
    }
    .apply-container {
        width: 100%;
        max-width: 600px;
        background: white;
        border-radius: 32px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
    }
    .close-modal {
        position: absolute;
        top: -40px;
        right: 0;
        color: white;
        font-size: 30px;
        cursor: pointer;
    }
    .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 16px; }
    .gallery-grid img { width: 100%; height: 220px; object-fit: cover; border-radius: 20px; transition: transform 0.3s; }
    .gallery-grid img:hover { transform: scale(1.03); }
    .outline-card { background: white; border-radius: 20px; padding: 24px; border: 1px solid #f0f0f0; transition: all 0.3s; }
    .outline-card:hover { box-shadow: 0 8px 30px rgba(74,14,78,0.08); transform: translateY(-4px); }
    .success-toast { animation: slideDown 0.5s ease; }
    @keyframes slideDown { from { transform: translateY(-100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>
@endsection

@section('content')

@if(session('success'))
<div class="success-toast" style="position:fixed;top:100px;left:50%;transform:translateX(-50%);z-index:2000;background:#059669;color:white;padding:16px 32px;border-radius:16px;font-weight:700;font-size:14px;box-shadow:0 8px 30px rgba(0,0,0,0.2);">
    <i class="fa-solid fa-check-circle" style="margin-right:8px;"></i>{{ session('success') }}
</div>
<script>setTimeout(()=>document.querySelector('.success-toast').style.display='none',5000)</script>
@endif

<section class="coop-hero">
    <div class="container">
        <span class="section-tag text-secondary border-secondary mb-6" style="display:inline-block;border:1px solid;padding:6px 20px;border-radius:50px;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;">Financial Empowerment</span>
        <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;margin:24px 0 16px;">{{ $setting->title ?? 'UBAA Lagos Cooperative Society' }}</h1>
        @if($setting && $setting->heading)
        <p style="font-size:18px;opacity:0.9;font-weight:600;margin-bottom:8px;">{{ $setting->heading }}</p>
        @endif
        <p style="max-width:640px;margin:0 auto 40px;font-size:16px;opacity:0.75;line-height:1.8;">{{ $setting->description ?? 'Building sustainable wealth through collective action and strategic investments.' }}</p>
        <div style="display:flex;flex-wrap:wrap;gap:16px;justify-content:center;">
            <a href="javascript:void(0)" onclick="openApplyModal()" class="btn btn-secondary" style="padding:16px 40px;font-weight:800;border-radius:14px;">{{ $setting->cta_text ?? 'Apply to Join' }}</a>
            <button onclick="openVideo()" class="btn btn-outline" style="border:2px solid white;color:white;padding:16px 40px;font-weight:800;border-radius:14px;background:transparent;cursor:pointer;">
                <i class="fa-solid fa-play-circle" style="font-size:18px;margin-right:8px;"></i>Virtual Estate Tour
            </button>
        </div>
    </div>
</section>

<section style="padding:80px 0;background:white;">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
            <div style="display:flex;flex-direction:column;gap:32px;">
                <div>
                    <h2 style="font-size:28px;font-weight:900;color:#4A0E4E;margin-bottom:16px;text-transform:uppercase;letter-spacing:-0.5px;">Why Join the Society?</h2>
                    <p style="color:#6b7280;line-height:1.8;">Our cooperative is designed to provide members with exclusive access to wealth-building opportunities that are typically reserved for institutional investors.</p>
                </div>

                <div style="display:flex;flex-direction:column;gap:16px;">
                    @php
                        $benefits = $setting && $setting->benefits ? explode("\n", $setting->benefits) : [
                            'Access to high-yield real estate investments at discounted rates.',
                            'Low-interest thrift and credit facilities for active members.',
                            'Collective bargaining power for asset acquisition.',
                            'Financial literacy workshops and wealth management advice.'
                        ];
                    @endphp
                    @foreach($benefits as $benefit)
                    @if(trim($benefit))
                    <div style="display:flex;align-items:flex-start;gap:12px;">
                        <div style="width:24px;height:24px;border-radius:50%;background:#dcfce7;color:#16a34a;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                            <i class="fa-solid fa-check" style="font-size:10px;"></i>
                        </div>
                        <p style="font-weight:700;color:#374151;">{{ trim($benefit) }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>

                <div style="background:rgba(74,14,78,0.04);padding:28px;border-radius:24px;border:1px solid rgba(74,14,78,0.08);">
                    <h4 style="font-weight:900;color:#4A0E4E;margin-bottom:6px;">Ready to take the next step?</h4>
                    <p style="font-size:12px;color:#6b7280;font-weight:500;margin-bottom:20px;">Complete the application form and our cooperative secretary will reach out to you with the next steps.</p>
                    <a href="javascript:void(0)" onclick="openApplyModal()" style="display:inline-block;background:#4A0E4E;color:white;padding:12px 32px;border-radius:14px;font-weight:700;font-size:14px;box-shadow:0 8px 20px rgba(74,14,78,0.2);text-decoration:none;">{{ $setting->cta_text ?? 'Apply to Join' }}</a>
                </div>
            </div>

            <div style="position:relative;">
                <div style="aspect-ratio:1;background:#f3f4f6;border-radius:40px;overflow:hidden;box-shadow:0 25px 50px rgba(0,0,0,0.1);position:relative;z-index:10;">
                    <img src="{{ $setting && $setting->image_url ? asset($setting->image_url) : asset('images/land.jpeg') }}" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div style="position:absolute;top:20px;left:-30px;background:white;padding:20px;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,0.1);z-index:20;max-width:180px;">
                    <p style="font-size:10px;font-weight:900;color:#9ca3af;text-transform:uppercase;letter-spacing:2px;margin-bottom:4px;">Total Members</p>
                    <p style="font-size:24px;font-weight:900;color:#4A0E4E;">{{ $setting->stats_members ?? '250+' }}</p>
                </div>
                @if($setting && $setting->stats_investments)
                <div style="position:absolute;bottom:20px;right:-20px;background:white;padding:20px;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,0.1);z-index:20;">
                    <p style="font-size:10px;font-weight:900;color:#9ca3af;text-transform:uppercase;letter-spacing:2px;margin-bottom:4px;">Investments</p>
                    <p style="font-size:24px;font-weight:900;color:#D4AF37;">{{ $setting->stats_investments }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Outlines Section --}}
@php $outlines = $setting && $setting->outlines ? array_filter(explode("\n", $setting->outlines)) : []; @endphp
@if(count($outlines) > 0)
<section style="padding:80px 0;background:#f8f9fa;">
    <div class="container">
        <div style="text-align:center;margin-bottom:48px;">
            <h2 style="font-size:28px;font-weight:900;color:#4A0E4E;margin-bottom:12px;">Key Features & Outlines</h2>
            <p style="color:#6b7280;max-width:500px;margin:0 auto;">What makes our cooperative society stand out from the rest.</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;">
            @foreach($outlines as $i => $outline)
            @if(trim($outline))
            <div class="outline-card">
                <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#4A0E4E,#6B1A70);color:white;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:14px;margin-bottom:16px;">{{ $i + 1 }}</div>
                <p style="font-weight:700;color:#374151;line-height:1.6;">{{ trim($outline) }}</p>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Gallery Section --}}
@if($setting && $setting->gallery_images && count($setting->gallery_images) > 0)
<section style="padding:80px 0;background:white;">
    <div class="container">
        <div style="text-align:center;margin-bottom:48px;">
            <h2 style="font-size:28px;font-weight:900;color:#4A0E4E;margin-bottom:12px;">Our Projects & Estates</h2>
            <p style="color:#6b7280;">A glimpse into the investments and developments by our cooperative society.</p>
        </div>
        <div class="gallery-grid">
            @foreach($setting->gallery_images as $image)
            <img src="{{ asset($image) }}" alt="Cooperative Gallery">
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Application Modal --}}
<div id="applyModal" class="apply-modal">
    <div class="apply-container">
        <span class="close-modal" onclick="closeApplyModal()" style="color:white;position:absolute;top:-45px;right:0;">&times;</span>
        <div style="padding:40px;">
            <div style="text-align:center;margin-bottom:32px;">
                <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#4A0E4E,#6B1A70);color:white;display:flex;align-items:center;justify-content:center;font-size:24px;margin:0 auto 16px;">🤝</div>
                <h3 style="font-size:22px;font-weight:900;color:#1f2937;">Join Our Cooperative</h3>
                <p style="color:#6b7280;font-size:13px;margin-top:4px;">Fill in your details and we'll get in touch with you.</p>
            </div>
            <form action="{{ route('cooperative.apply') }}" method="POST">
                @csrf
                <div style="display:flex;flex-direction:column;gap:16px;">
                    <div>
                        <label style="display:block;font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:2px;margin-bottom:6px;padding-left:4px;">Full Name *</label>
                        <input type="text" name="full_name" required style="width:100%;padding:14px 18px;background:#f9fafb;border:none;border-radius:14px;font-size:14px;font-weight:600;color:#374151;outline:none;" placeholder="Enter your full name">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div>
                            <label style="display:block;font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:2px;margin-bottom:6px;padding-left:4px;">Email Address *</label>
                            <input type="email" name="email" required style="width:100%;padding:14px 18px;background:#f9fafb;border:none;border-radius:14px;font-size:14px;font-weight:600;color:#374151;outline:none;" placeholder="your@email.com">
                        </div>
                        <div>
                            <label style="display:block;font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:2px;margin-bottom:6px;padding-left:4px;">Phone Number *</label>
                            <input type="text" name="phone" required style="width:100%;padding:14px 18px;background:#f9fafb;border:none;border-radius:14px;font-size:14px;font-weight:600;color:#374151;outline:none;" placeholder="080XXXXXXXX">
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div>
                            <label style="display:block;font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:2px;margin-bottom:6px;padding-left:4px;">Occupation</label>
                            <input type="text" name="occupation" style="width:100%;padding:14px 18px;background:#f9fafb;border:none;border-radius:14px;font-size:14px;font-weight:600;color:#374151;outline:none;" placeholder="Your current job">
                        </div>
                        <div>
                            <label style="display:block;font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:2px;margin-bottom:6px;padding-left:4px;">Matric Number</label>
                            <input type="text" name="matric_number" style="width:100%;padding:14px 18px;background:#f9fafb;border:none;border-radius:14px;font-size:14px;font-weight:600;color:#374151;outline:none;" placeholder="UBxx/xxxx">
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div>
                            <label style="display:block;font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:2px;margin-bottom:6px;padding-left:4px;">Graduation Year</label>
                            <input type="text" name="graduation_year" style="width:100%;padding:14px 18px;background:#f9fafb;border:none;border-radius:14px;font-size:14px;font-weight:600;color:#374151;outline:none;" placeholder="e.g. 2015">
                        </div>
                        <div>
                            <label style="display:block;font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:2px;margin-bottom:6px;padding-left:4px;">Address</label>
                            <input type="text" name="address" style="width:100%;padding:14px 18px;background:#f9fafb;border:none;border-radius:14px;font-size:14px;font-weight:600;color:#374151;outline:none;" placeholder="Your address">
                        </div>
                    </div>
                    <div>
                        <label style="display:block;font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:2px;margin-bottom:6px;padding-left:4px;">Why do you want to join?</label>
                        <textarea name="reason" rows="3" style="width:100%;padding:14px 18px;background:#f9fafb;border:none;border-radius:14px;font-size:14px;font-weight:600;color:#374151;outline:none;resize:vertical;" placeholder="Tell us briefly..."></textarea>
                    </div>
                    <button type="submit" style="width:100%;padding:16px;background:#4A0E4E;color:white;border:none;border-radius:14px;font-size:15px;font-weight:800;cursor:pointer;box-shadow:0 8px 20px rgba(74,14,78,0.2);margin-top:8px;">
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Video Modal --}}
<div id="videoModal" class="video-modal">
    <div class="video-container">
        <span class="close-modal" onclick="closeVideo()">&times;</span>
        <div id="videoWrapper" style="width:100%;height:100%;">
            @if($setting && $setting->video_url)
                @if(str_contains($setting->video_url, 'youtube.com') || str_contains($setting->video_url, 'youtu.be'))
                    @php
                        $videoId = '';
                        if(str_contains($setting->video_url, 'v=')) {
                            parse_str(parse_url($setting->video_url, PHP_URL_QUERY), $vars);
                            $videoId = $vars['v'];
                        } else {
                            $videoId = basename(parse_url($setting->video_url, PHP_URL_PATH));
                        }
                    @endphp
                    <iframe style="width:100%;height:100%;" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                @else
                    <video style="width:100%;height:100%;" controls>
                        <source src="{{ asset($setting->video_url) }}" type="video/mp4">
                    </video>
                @endif
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#111;color:white;font-weight:700;padding:40px;text-align:center;">
                    <p>No virtual tour video available at the moment. Check back soon!</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('extra_js')
<script>
    function openVideo() {
        document.getElementById('videoModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeVideo() {
        document.getElementById('videoModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        const wrapper = document.getElementById('videoWrapper');
        wrapper.innerHTML = wrapper.innerHTML;
    }
    function openApplyModal() {
        @if($setting && $setting->application_link)
            window.open('{{ $setting->application_link }}', '_blank');
        @else
            document.getElementById('applyModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        @endif
    }
    function closeApplyModal() {
        document.getElementById('applyModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    document.getElementById('applyModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeApplyModal();
    });
</script>
@endsection
