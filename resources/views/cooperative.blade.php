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

    /* FAQ Section Styles */
    .faq-section {
        padding: 85px 0;
        background: #fdfdfd;
        border-top: 1px solid #f0f0f0;
    }
    .faq-title-block {
        text-align: center;
        margin-bottom: 50px;
    }
    .faq-title-block h2 {
        font-size: 32px;
        font-weight: 900;
        color: var(--primary);
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: -0.5px;
    }
    .faq-title-block p {
        color: var(--text-gray);
        max-width: 600px;
        margin: 0 auto;
        font-size: 15px;
    }
    .faq-container {
        max-width: 900px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .faq-item {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(74, 14, 78, 0.05);
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        overflow: hidden;
        transition: all 0.35s ease;
    }
    .faq-item.active {
        border-color: var(--primary);
        box-shadow: 0 12px 30px rgba(74, 14, 78, 0.08);
    }
    .faq-header {
        padding: 24px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        user-select: none;
        transition: background-color 0.3s;
        gap: 16px;
    }
    .faq-header:hover {
        background-color: rgba(74, 14, 78, 0.02);
    }
    .faq-question {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary);
        line-height: 1.4;
    }
    .faq-icon {
        font-size: 14px;
        color: var(--secondary);
        transition: transform 0.3s ease;
        flex-shrink: 0;
    }
    .faq-item.active .faq-icon {
        transform: rotate(180deg);
    }
    .faq-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
    }
    .faq-content {
        padding: 0 28px 24px 28px;
        font-size: 15px;
        color: var(--text-gray);
        line-height: 1.8;
    }
    .faq-content strong {
        color: var(--text-dark);
    }
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

{{-- Cooperative Estate Scheme Section --}}
<section style="padding:90px 0;background:#fafafa;border-top:1px solid #f0f0f0;border-bottom:1px solid #f0f0f0;">
    <div class="container">
        <div style="text-align:center;margin-bottom:48px;">
            <span class="section-tag" style="display:inline-block;border:1px solid;padding:6px 20px;border-radius:50px;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--primary);margin-bottom:12px;">Premium Project</span>
            <h2 style="font-size:32px;font-weight:900;color:#4A0E4E;margin-bottom:16px;">UNIBEN Alumni Cooperative Estate</h2>
            <p style="color:#6b7280;max-width:600px;margin:0 auto;line-height:1.6;font-size:15px;">A premier residential estate offering a safe, secure, and modern lifestyle at Idi-Obi, Arapagi, Bogije axis of Lagos State.</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:24px;margin-bottom:40px;">
            <!-- Location Card -->
            <div class="outline-card" style="display:flex;flex-direction:column;gap:12px;">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(74,14,78,0.05);color:var(--primary);display:flex;align-items:center;justify-content:center;font-size:20px;">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <h3 style="font-size:18px;font-weight:800;color:var(--primary);">Strategic Location</h3>
                <p style="font-size:14px;color:#6b7280;line-height:1.6;flex-grow:1;">Located at <strong>Idi-Obi, Arapagi, Bogije axis, Lagos State</strong>. Enjoying close proximity to the proposed Elerangbe Int'l Airport. Accessibility is highly optimized with an ongoing direct Sangotedo link road and waterways ferry routes.</p>
            </div>

            <!-- Land Specs Card -->
            <div class="outline-card" style="display:flex;flex-direction:column;gap:12px;">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(212,175,55,0.1);color:var(--secondary-dark);display:flex;align-items:center;justify-content:center;font-size:20px;">
                    <i class="fa-solid fa-maximize"></i>
                </div>
                <h3 style="font-size:18px;font-weight:800;color:var(--primary);">Plot Specifications</h3>
                <p style="font-size:14px;color:#6b7280;line-height:1.6;flex-grow:1;">Each standard plot measures exactly <strong>500 square metres (500sqm)</strong>. Designed as a perfect layout for residential comfort, development, and shared prosperity.</p>
            </div>

            <!-- Price & Title Card -->
            <div class="outline-card" style="display:flex;flex-direction:column;gap:12px;">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(22,163,74,0.05);color:#16a34a;display:flex;align-items:center;justify-content:center;font-size:20px;">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <h3 style="font-size:18px;font-weight:800;color:var(--primary);">Pricing & Secure Title</h3>
                <p style="font-size:14px;color:#6b7280;line-height:1.6;flex-grow:1;">Purchasable at <strong>₦10,000,000 per plot</strong>. Includes **Global C of O** and Deed. Subscribers can process their Governor's Consent upon full payment completion.</p>
            </div>

            <!-- Payment Plans Card -->
            <div class="outline-card" style="display:flex;flex-direction:column;gap:12px;">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(147,51,234,0.05);color:#9333ea;display:flex;align-items:center;justify-content:center;font-size:20px;">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h3 style="font-size:18px;font-weight:800;color:var(--primary);">Installment Options</h3>
                <p style="font-size:14px;color:#6b7280;line-height:1.6;flex-grow:1;">Flexible payment plan of <strong>3 to 6 months</strong> is available. Subscriptions require a <strong>30% initial deposit</strong>, with maximum payments capped at 3 installments.</p>
            </div>
        </div>

        <div style="background:linear-gradient(135deg, var(--primary), var(--primary-light));color:white;padding:32px 40px;border-radius:24px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:24px;">
            <div style="flex:1;min-width:280px;">
                <h3 style="font-size:22px;font-weight:800;margin-bottom:8px;">Interested in subscribing to a plot?</h3>
                <p style="font-size:14px;opacity:0.8;line-height:1.5;">Apply today to lock in your plot. Open to members of the society and referred non-members.</p>
            </div>
            <div style="display:flex;gap:16px;">
                <a href="javascript:void(0)" onclick="openApplyModal()" class="btn btn-secondary" style="padding:14px 28px;border-radius:12px;font-weight:800;">Apply for Land</a>
                <a href="{{ asset('storage/Uniben_Alumni_cooperative_Estate.pdf') }}" download target="_blank" class="btn btn-outline" style="border:2px solid white;color:white;padding:14px 28px;border-radius:12px;font-weight:800;background:transparent;">
                    <i class="fa-solid fa-file-pdf"></i> Download Scheme FAQ & Form
                </a>
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

{{-- FAQ Section --}}
<section class="faq-section" id="faq">
    <div class="container">
        <div class="faq-title-block">
            <span class="section-tag" style="display:inline-block;border:1px solid;padding:6px 20px;border-radius:50px;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--primary);margin-bottom:12px;">Got Questions?</span>
            <h2>Cooperative Estate FAQs</h2>
            <p>Find answers to common questions about our property specifications, accessibility, payment structures, and title documentation.</p>
        </div>

        <div class="faq-container">
            <!-- FAQ 1 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">1. What is UNIBEN Alumni Lagos Cooperative Estate?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        UNIBEN Alumni Lagos Cooperative Estate is a real estate initiative of the UNIBEN Alumni Lagos Cooperative Society, created to provide affordable and secure land ownership opportunities for members and interested non-members.
                    </div>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">2. Where is the estate located?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        The estate is located at <strong>Idi-Obi, Arapagi, Bogije axis of Lagos State</strong>.<br>
                        It enjoys close proximity to the proposed Elerangbe International Airport, making it a highly strategic and future-forward investment location. There is an ongoing construction of a major link road from Sangotedo (opposite Shoprite) directly to the estate, which will significantly improve accessibility. In addition, access to the estate can also be achieved via waterways (ferry transport), offering a faster and alternative route. Detailed site information, inspection schedules, and access guidance will be communicated to subscribers by the estate management.
                    </div>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">3. Who can buy land in the estate?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        Members of the UNIBEN Alumni Lagos Cooperative Society and any non-members who wish to buy. However, any non-member subscriber must be introduced by an active, existing member of the society.
                    </div>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">4. What is the size of each land allocation?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        Each standard plot measures <strong>500 square metres (500sqm)</strong>.
                    </div>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">5. What is the cost of land?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        The land is priced at <strong>₦10,000,000 (10 Million Naira) per plot</strong>, which includes a Global C of O and Deed of Assignment.
                    </div>
                </div>
            </div>

            <!-- FAQ 6 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">6. Is there a payment plan?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        Yes, a flexible <strong>3 to 6 months</strong> installment plan is available for subscribers.
                    </div>
                </div>
            </div>

            <!-- FAQ 7 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">7. How does the payment plan work?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        An <strong>initial deposit of 30%</strong> is required. The balance must be cleared within 3 to 6 months, and payments cannot exceed 3 installments.
                    </div>
                </div>
            </div>

            <!-- FAQ 8 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">8. Can payments be made more frequently than three installments?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        No. Payments are strictly structured to be made a maximum of three times within the agreed payment window.
                    </div>
                </div>
            </div>

            <!-- FAQ 9 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">9. What happens if I default on payment?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        Failure to complete payment within the stipulated period may result in forfeiture or penalties, subject to the cooperative's standard terms and conditions.
                    </div>
                </div>
            </div>

            <!-- FAQ 10 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">10. Are development fees included in the land price?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        No. Development fees are charged separately and will be communicated to all subscribers at a later date.
                    </div>
                </div>
            </div>

            <!-- FAQ 11 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">11. When will the development fee be paid?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        Development fees will be determined and charged later, accounting for inflation and prevailing economic conditions at the time development begins.
                    </div>
                </div>
            </div>

            <!-- FAQ 12 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">12. Is Certificate of Occupancy (C of O) included in the price?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        Yes, the land price includes a <strong>Global C of O and Deed</strong>. However, subscribers can independently process their Governor's Consent after they complete their payments.
                    </div>
                </div>
            </div>

            <!-- FAQ 13 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">13. Is land survey included in the land price?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        No. Land survey fees are separate and payable after full payment towards the land purchase has been completed.
                    </div>
                </div>
            </div>

            <!-- FAQ 14 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">14. When will allocation be done?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        Allocation will be carried out after completion of payment and fulfillment of all required documentation.
                    </div>
                </div>
            </div>

            <!-- FAQ 15 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">15. Will I receive an allocation letter?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        Yes. Successful subscribers will receive an official Allocation Letter from the cooperative.
                    </div>
                </div>
            </div>

            <!-- FAQ 16 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">16. Can I resell or transfer my land?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        Resale or transfer is subject to the formal approval and guidelines of the UNIBEN Alumni Lagos Cooperative Society.
                    </div>
                </div>
            </div>

            <!-- FAQ 17 -->
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">
                    <span class="faq-question">17. Who do I contact for enquiries?</span>
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-body">
                    <div class="faq-content">
                        All enquiries should be directed to the cooperative secretariat:<br>
                        <strong>3 William Carew crescent Anthony-Maryland, Lagos.</strong><br>
                        Or call phone support: <strong>+234 806 760 7870</strong>, <strong>+234 803 443 2804</strong>, or <strong>+234 806 504 6269</strong>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                        <label style="display:block;font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:2px;margin-bottom:6px;padding-left:4px;">Application details (e.g. Reason for joining, or Plot details if subscribing to land)</label>
                        <textarea name="reason" rows="3" style="width:100%;padding:14px 18px;background:#f9fafb;border:none;border-radius:14px;font-size:14px;font-weight:600;color:#374151;outline:none;resize:vertical;" placeholder="Specify why you want to join the cooperative society, or indicate the number of plots and payment plan if subscribing to the Uniben Alumni Cooperative Estate."></textarea>
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
    function toggleFaq(el) {
        const item = el.parentElement;
        const body = item.querySelector('.faq-body');
        const isActive = item.classList.contains('active');
        
        // Close all other items
        document.querySelectorAll('.faq-item').forEach(otherItem => {
            if (otherItem !== item) {
                otherItem.classList.remove('active');
                otherItem.querySelector('.faq-body').style.maxHeight = null;
            }
        });
        
        if (isActive) {
            item.classList.remove('active');
            body.style.maxHeight = null;
        } else {
            item.classList.add('active');
            body.style.maxHeight = body.scrollHeight + "px";
        }
    }

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
