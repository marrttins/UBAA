<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UNIBEN Alumni Lagos Branch')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/uniben-logo.png') }}">

    <style>
        :root {
            --primary: #4A0E4E;
            --primary-light: #5A1B5E;
            --secondary: #D4AF37;
            --secondary-dark: #B38F2D;
            --bg-body: #fdfdfd;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --white: #ffffff;
            --accent: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        a { text-decoration: none; transition: 0.3s; }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Navbar */
        nav {
            height: 90px;
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .nav-inner {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 20px;
            color: var(--primary);
            line-height: 1;
        }

        .logo img {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #000;
            padding: 4px;
        }

        .nav-links {
            display: flex;
            gap: 24px;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-gray);
            font-size: 14px;
            font-weight: 600;
        }

        .nav-links a:hover { color: var(--primary); }

        .nav-auth {
            display: flex;
            gap: 16px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-outline {
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(74, 14, 78, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 14, 78, 0.3);
        }

        .btn-secondary {
            background: var(--secondary);
            color: var(--primary);
        }

        /* Footer */
        footer {
            background: var(--primary);
            color: white;
            padding: 80px 0 40px;
            margin-top: 100px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .footer-logo {
            margin-bottom: 24px;
            color: white;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 24px;
        }

        .footer-logo img {
            width: 40px;
            height: 40px;
            background: white;
            padding: 2px;
            border-radius: 8px;
        }

        .footer-col h4 {
            font-size: 18px;
            margin-bottom: 24px;
            color: var(--secondary);
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col ul li a {
            color: rgba(255,255,255,0.7);
            font-size: 14px;
        }

        .footer-col ul li a:hover { color: var(--secondary); }

        .footer-bottom {
            padding-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            font-size: 14px;
            color: rgba(255,255,255,0.5);
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            
            /* Hide desktop nav on very small screens if we use mobile top bar */
            /* But Keep it on home where mobile bars are hidden */
            nav { display: {{ request()->routeIs('home') ? 'flex' : 'none' }}; }
        }

        /* Mobile Bottom Nav */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: white;
            display: none;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            z-index: 2000;
        }

        .m-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #94a3b8;
            font-size: 10px;
            font-weight: 700;
            gap: 4px;
        }

        .m-nav-item i { font-size: 20px; }
        .m-nav-item.active { color: var(--primary); }

        /* Mobile Top Bar */
        .mobile-top-bar {
            height: 70px;
            background: white;
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 1500;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        @media (max-width: 768px) {
            .mobile-bottom-nav { display: flex; }
            .mobile-top-bar { display: flex; }
            main { padding-bottom: 80px; } /* Space for bottom nav */
        }
    </style>
    @yield('extra_css')
</head>
<body>

@if(!request()->routeIs('home'))
<!-- Mobile Top Bar -->
<div class="mobile-top-bar">
    <div style="display: flex; align-items: center; gap: 10px;">
        <img src="{{ asset('images/uniben-logo.png') }}" alt="Logo" style="width: 32px; height: 32px; border-radius: 50%; background: #000; padding: 2px;">
        <span style="font-weight: 800; color: var(--primary); font-size: 14px;">UBAA <small style="font-size: 8px; color: var(--secondary);">LAGOS BRANCH</small></span>
    </div>
    <div style="color: var(--primary); font-size: 18px;">
        <i class="fa-solid fa-bell"></i>
    </div>
</div>
@endif

<nav>
    <div class="container nav-inner">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/uniben-logo.png') }}" alt="Logo">
            <span>UBAA<small style="display: block; font-size: 10px; font-weight: 500; opacity: 0.7; margin-top: 4px;">LAGOS BRANCH</small></span>
        </a>
        
        <div class="nav-links">
            <a href="{{ route('home') }}#about">About</a>
            <a href="{{ route('membership') }}">Membership</a>
            <a href="{{ route('home') }}#benefits">Benefits</a>
            <a href="{{ auth()->check() ? route('news.index') : route('home').'#news' }}">News</a>
            <a href="{{ route('home') }}#events">Programs</a>
            <a href="{{ route('shop') }}">Shop</a>
            <a href="{{ route('jobs') }}">Jobs</a>
            <a href="{{ route('home') }}#team">Leadership</a>
            <a href="{{ route('home') }}#contact">Contact</a>
        </div>

        <div class="nav-auth">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
                <a href="{{ route('signup') }}" class="btn btn-primary">Join Now</a>
            @endauth
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="footer-logo">
                    <img src="{{ asset('images/uniben-logo.png') }}" alt="Logo">
                    <span>UNIBEN ALUMNI<br><small style="font-size: 12px; color: var(--secondary);">LAGOS BRANCH</small></span>
                </div>
                <p style="color: rgba(255,255,255,0.6); max-width: 300px;">
                    Upholding the excellence and heritage of the University of Benin through our vibrant Lagos Branch network.
                </p>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('home') }}#about">About Us</a></li>
                    <li><a href="{{ route('membership') }}">Membership</a></li>
                    <li><a href="{{ auth()->check() ? route('news.index') : route('home').'#news' }}">Latest News</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <ul>
                    
                    <li><a href="{{ route('dashboard') }}">Directory</a></li>
                    
                    <li><a href="{{ route('home') }}#contact">Contact Support</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Connect</h4>
                <div style="display: flex; gap: 16px; margin-top: 12px;">
                    <a href="#" style="color: white; font-size: 20px;"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" style="color: white; font-size: 20px;"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" style="color: white; font-size: 20px;"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="#" style="color: white; font-size: 20px;"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} University of Benin Alumni Association, Lagos Branch.
        </div>
    </div>
</footer>

@if(!request()->routeIs('home'))
<!-- Mobile Bottom Navigation -->
<div class="mobile-bottom-nav">
    <a href="{{ route('home') }}" class="m-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>
        <span>HOME</span>
    </a>
    <a href="{{ route('dashboard') }}" class="m-nav-item">
        <i class="fa-solid fa-user-group"></i>
        <span>DIRECTORY</span>
    </a>
    <a href="{{ route('shop') }}" class="m-nav-item">
        <i class="fa-solid fa-store"></i>
        <span>SHOP</span>
    </a>
    <a href="{{ route('payments') }}" class="m-nav-item">
        <i class="fa-solid fa-wallet"></i>
        <span>PAYMENTS</span>
    </a>
    <a href="{{ route('profile') }}" class="m-nav-item">
        <i class="fa-regular fa-user"></i>
        <span>PROFILE</span>
    </a>
</div>
@endif

@yield('extra_js')
</body>
</html>
