@extends('layouts.landing')

@section('title', 'Membership | UNIBEN Alumni Lagos')

@section('extra_css')
<style>
    .page-header {
        padding: 80px 0;
        background: var(--primary);
        color: white;
        text-align: center;
    }
    .membership-content {
        padding: 80px 0;
    }
    .benefits-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
        margin-top: 40px;
    }
    .benefit-item {
        background: white;
        padding: 30px;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        display: flex;
        gap: 24px;
        transition: 0.3s;
    }
    .benefit-item:hover {
        border-color: var(--secondary);
        transform: translateX(10px);
    }
    .benefit-num {
        width: 40px;
        height: 40px;
        background: var(--secondary);
        color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        flex-shrink: 0;
    }
    .fee-card {
        background: var(--accent);
        border-radius: 24px;
        padding: 40px;
        text-align: center;
        border: 2px dashed var(--secondary);
        position: sticky;
        top: 120px;
    }
    .fee-amount {
        font-size: 48px;
        font-weight: 800;
        color: var(--primary);
        margin: 20px 0;
    }
    .secretary-msg {
        background: #fff;
        padding: 40px;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-top: 60px;
        border-left: 8px solid var(--secondary);
    }
</style>
@endsection

@section('content')

<div class="page-header">
    <div class="container">
        <h1 style="font-size: 48px; font-weight: 800; margin-bottom: 16px;">Branch Membership</h1>
        <p style="opacity: 0.8; font-size: 18px;">Empowering graduates of Great Benin in Lagos State.</p>
    </div>
</div>

<div class="membership-content">
    <div class="container">
        <div style="display: grid; grid-template-columns: 2fr 1.2fr; gap: 60px;">
            <div>
                <h2 style="color: var(--primary); margin-bottom: 24px;">The Benefits of Membership of UBAA Lagos</h2>
                <p style="color: var(--text-gray); font-size: 15px; margin-bottom: 24px;">
                    By default, all Uniben graduates are members of the Alumni Association. However, only few take interest in it. 
                    Of course there are a whole lot to gain as a member, nay, active member of the Association.
                </p>

                <div class="benefits-list">
                    <div class="benefit-item">
                        <div class="benefit-num">1</div>
                        <div>
                            <h4 style="color: var(--primary); margin-bottom: 10px;">Job Connection</h4>
                            <p style="color: var(--text-gray); font-size: 14px;">This tops the value chain as a member. At meetings, you will meet Employers of labour and Influencers of employment; I don't need to belabour that.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-num">2</div>
                        <div>
                            <h4 style="color: var(--primary); margin-bottom: 10px;">Mentorship</h4>
                            <p style="color: var(--text-gray); font-size: 14px;">The Association boasts of seasoned professionals who willingly take up the younger generation and mentor them to fruition for free.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-num">3</div>
                        <div>
                            <h4 style="color: var(--primary); margin-bottom: 10px;">Networking</h4>
                            <p style="color: var(--text-gray); font-size: 14px;">At the Alumni gathering, you meet old course mates, classmates, set mates, faculty mates and your seniors or juniors. A galaxy of professionals in one forum.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-num">4</div>
                        <div>
                            <h4 style="color: var(--primary); margin-bottom: 10px;">Free Workshops/Seminar</h4>
                            <p style="color: var(--text-gray); font-size: 14px;">Nearly every meeting, professionals from varying sectors are invited to give talk on various subjects ranging from health, law, finance, insurance etc.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-num">5</div>
                        <div>
                            <h4 style="color: var(--primary); margin-bottom: 10px;">Admission of Wards</h4>
                            <p style="color: var(--text-gray); font-size: 14px;">Admission into Uniben is a tough one. But as a member, you are privileged to have a leverage with just the barest minimum qualification.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-num">6</div>
                        <div>
                            <h4 style="color: var(--primary); margin-bottom: 10px;">Robust Welfare Programme</h4>
                            <p style="color: var(--text-gray); font-size: 14px;">In our Alumni Association, we are our brothers' keepers. In good times, we celebrate with you, in bad times, we identify with you.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-num">7</div>
                        <div>
                            <h4 style="color: var(--primary); margin-bottom: 10px;">Support for School Needs</h4>
                            <p style="color: var(--text-gray); font-size: 14px;">Our Alumni Relations Unit in the school will assist you fast track needs like transcripts or certificates if recommended by our Branch.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-num">8</div>
                        <div>
                            <h4 style="color: var(--primary); margin-bottom: 10px;">World Wide Link</h4>
                            <p style="color: var(--text-gray); font-size: 14px;">Once you are a member of good standing, the world is in your pocket. We are everywhere in the universe.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-num">9</div>
                        <div>
                            <h4 style="color: var(--primary); margin-bottom: 10px;">Forum to Showcase Goods and Services</h4>
                            <p style="color: var(--text-gray); font-size: 14px;">We offer you our platform to advertise your goods and services free of charge to our wide network of alumni.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-num">10</div>
                        <div>
                            <h4 style="color: var(--primary); margin-bottom: 10px;">Cooperative Society</h4>
                            <p style="color: var(--text-gray); font-size: 14px;">Access to the UBAA Lagos Coop Society with numerous financial benefits and investment opportunities.</p>
                        </div>
                    </div>
                </div>

                <div class="secretary-msg">
                    <p style="font-style: italic; font-size: 16px; margin-bottom: 20px;">
                        "Do you still have doubt why you should not be an active member of the prestigious University of Benin Alumni Association, Lagos Branch? Still need to know more about these benefits? We are just a phone call away! Your welfare is our concern."
                    </p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong style="color: var(--primary);">Contact: 08033268331</strong><br>
                            <span style="font-size: 14px; color: var(--text-gray);">- Welfare Secretary</span>
                        </div>
                        <div style="font-weight: 800; color: var(--secondary); text-transform: uppercase;">Be Active! Be Live!!</div>
                    </div>
                </div>
            </div>

            <div class="sidebar">
                <div class="fee-card">
                    <h3 style="color: var(--primary); font-size: 20px;">Annual Membership Dues</h3>
                    <p style="font-size: 14px; opacity: 0.7; margin-top: 10px;">Support the branch and maintain active status</p>
                    <div class="fee-amount">₦20,000</div>
                    <p style="font-size: 12px; margin-bottom: 30px; color: var(--text-gray);">Payable yearly by all registered branch members.</p>
                    <a href="{{ route('signup') }}" class="btn btn-primary" style="width: 100%; justify-content: center;">Register / Renew Now</a>
                    <p style="font-size: 11px; margin-top: 16px; color: var(--text-gray);">Need assistance? Contact our Financial Secretary.</p>
                </div>

                <div style="margin-top: 40px; padding: 30px; background: white; border-radius: 20px; border: 1px solid rgba(0,0,0,0.05);">
                    <h4 style="color: var(--primary); margin-bottom: 16px;">Next Meeting</h4>
                    <p style="font-size: 14px; color: var(--text-gray); margin-bottom: 20px;">Join us for our monthly physical meeting to experience these benefits firsthand.</p>
                    <div style="display: flex; align-items: center; gap: 12px; color: var(--primary); font-weight: 600;">
                        <i class="fa-solid fa-calendar"></i>
                        <span>Last Sunday of Every Month</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; color: var(--primary); font-weight: 600; margin-top: 12px;">
                        <i class="fa-solid fa-clock"></i>
                        <span>4:00 PM Prompt</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
