<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | UNIBEN Alumni Lagos</title>
    <link rel="icon" type="image/png" href="{{ asset('images/uniben-logo.png') }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script id="tailwind-config">
          tailwind.config = {
            darkMode: "class",
            theme: {
              extend: {
                colors: {
                  "primary": "#4A0E4E",
                  "secondary": "#D4AF37",
                  "bg-body": "#f8f9fa",
                },
                fontFamily: {
                  "headline": ["Manrope"],
                  "body": ["Inter"],
                },
              },
            },
          }
    </script>
    
    <style>
        :root {
            --primary: #4A0E4E;
            --secondary: #D4AF37;
            --bg-body: #f8f9fa;
            --sidebar-width: 260px;
            --bottom-nav-height: 80px;
        }

        body {
            background-color: #f3f4f6;
            color: #1a1c1d;
            font-family: 'Inter', sans-serif;
            margin: 0;
            min-height: 100vh;
        }

        .layout-wrapper {
            display: flex;
            flex-direction: column;
            width: 100%;
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid #e5e7eb;
            width: 100%;
        }

        .sidebar {
            display: none;
            width: var(--sidebar-width);
            background: #fff;
            height: calc(100vh - 73px);
            position: sticky;
            top: 73px;
            border-right: 1px solid #e5e7eb;
            padding: 24px;
            flex-direction: column;
            gap: 8px;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            height: var(--bottom-nav-height);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0 16px;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.05);
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            z-index: 100;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            text-decoration: none;
            transition: 0.2s;
            padding: 12px;
            border-radius: 12px;
        }

        .sidebar .nav-item {
            flex-direction: row;
            justify-content: flex-start;
            gap: 16px;
            width: 100%;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-item.active {
            color: #fff;
            background: var(--primary);
        }

        .nav-item i { font-size: 20px; }
        .nav-item span { font-size: 9px; font-weight: 700; }
        .sidebar .nav-item span { font-size: 14px; }

        .main-content {
            flex: 1;
            padding: 24px;
            width: 100%;
        }

        @media (min-width: 1024px) {
            .layout-wrapper { flex-direction: row; flex-wrap: wrap; }
            .sidebar { display: flex; }
            .bottom-nav { display: none; }
            .main-content { padding: 40px; }
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="font-body">

@php
    function getUsername($url) {
        if (!$url) return 'Not Linked';
        $purl = parse_url($url);
        $path = $purl['path'] ?? '';
        $segments = explode('/', trim($path, '/'));
        
        if (strpos($url, 'linkedin.com') !== false) {
            return $segments[1] ?? ($segments[0] ?? 'LinkedIn Alum');
        }
        return end($segments) ?: 'Profile Link';
    }

    $alumniLevel = $user->calculateAlumniLevel();
    $isOwnProfile = auth()->id() === $user->id;

    $iRequested = null;
    $theyRequested = null;
    $isConnected = false;

    if (!$isOwnProfile) {
        $iRequested = \App\Models\Connection::where('user_id', auth()->id())->where('connected_user_id', $user->id)->first();
        $theyRequested = \App\Models\Connection::where('user_id', $user->id)->where('connected_user_id', auth()->id())->first();
        $isConnected = ($iRequested && $iRequested->status === 'accepted') || ($theyRequested && $theyRequested->status === 'accepted');
    }

    $isBirthday = false;
    if ($user->date_of_birth) {
        $dob = \Carbon\Carbon::parse($user->date_of_birth);
        if ($dob->isBirthday()) {
            $isBirthday = true;
        }
    }
@endphp


<div class="layout-wrapper">
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/uniben-logo.png') }}" class="w-9 h-9 rounded-full bg-black p-0.5 object-contain">
            <span class="text-primary font-bold">Member Profile</span>
        </div>
        <a href="{{ route('notifications') }}" class="relative text-primary text-xl">
            <i class="fa-solid fa-bell"></i>
            @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[8px] font-black flex items-center justify-center rounded-full border-2 border-white animation-pulse">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
            @endif
        </a>
    </header>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content mb-24 lg:mb-0">
        @if(session('success'))
            <div class="max-w-4xl mx-auto mb-6 bg-green-50 text-green-600 p-4 rounded-3xl border border-green-100 text-sm font-bold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Hero Card -->
        <section class="bg-white rounded-[32px] p-8 md:p-12 shadow-sm border border-gray-50 mb-12 relative overflow-hidden">
            <div class="flex flex-col lg:flex-row items-center gap-10 relative z-10">
                <div class="relative">
                    <div class="w-40 h-40 rounded-3xl bg-primary/5 p-1 ring-4 ring-primary/10 overflow-hidden shadow-2xl">
                        <img src="{{ $user->avatar_url ? asset($user->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=4A0E4E&color=fff&size=512' }}" class="w-full h-full object-cover rounded-2xl">
                    </div>
                    @if($isBirthday)
                    <div class="absolute -top-4 -left-4 text-4xl animate-bounce">🎈</div>
                    <div class="absolute -top-4 -right-4 text-4xl animate-bounce" style="animation-delay: 0.2s">🎈</div>
                    @endif
                </div>
                <div class="flex-1 text-center lg:text-left">
                    <div class="flex flex-col lg:flex-row items-center gap-3 mb-2">
                        <h2 class="text-3xl md:text-5xl font-black text-primary tracking-tight">
                            <span class="text-secondary/50">{{ $user->title }}</span> {{ $user->name ?? 'Member Name' }}
                        </h2>
                        <span class="px-3 py-1 bg-secondary/10 text-secondary text-[10px] font-black rounded-full uppercase tracking-widest border border-secondary/20">{{ $alumniLevel }} Rank</span>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-6">{{ $user->degree ?? 'Alumnus' }} • Class of {{ $user->graduation_year ?? 'N/A' }}</p>
                    <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                        @if($isOwnProfile)
                        <a href="{{ route('profile.edit') }}" class="bg-primary text-white px-8 py-3 rounded-xl font-bold text-xs shadow-lg shadow-primary/10 hover:brightness-110 active:scale-95 transition-all uppercase tracking-widest">EDIT PERSONAL INFO</a>
                        @else
                        <form action="{{ route('directory.connect') }}" method="POST" class="inline-block">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            @if($isConnected)
                                 <button type="button" class="bg-gray-100 text-gray-400 px-8 py-3 rounded-xl font-bold text-xs cursor-default uppercase tracking-widest">CONNECTED</button>
                            @elseif($iRequested)
                                 <button type="button" class="bg-secondary/10 text-secondary px-8 py-3 rounded-xl font-bold text-xs cursor-default uppercase tracking-widest">PENDING REQUEST</button>
                            @elseif($theyRequested)
                                 <button type="submit" class="bg-secondary text-primary px-8 py-3 rounded-xl font-bold text-xs hover:brightness-110 active:scale-95 transition-all shadow-lg uppercase tracking-widest">ACCEPT CONNECTION</button>
                            @else
                                 <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold text-xs hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-primary/10 uppercase tracking-widest">CONNECT</button>
                            @endif
                        </form>
                        <a href="mailto:{{ $user->email }}" class="bg-gray-50 text-primary border border-gray-100 px-8 py-3 rounded-xl font-bold text-xs hover:bg-primary hover:text-white active:scale-95 transition-all uppercase tracking-widest">SEND MESSAGE</a>
                        @endif
                        <button onclick="shareIdentity()" class="bg-gray-50 text-gray-400 px-8 py-3 rounded-xl font-bold text-xs border border-gray-100 hover:bg-gray-100 active:scale-95 transition-all uppercase tracking-widest">SHARE IDENTITY</button>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6 lg:gap-12 w-full lg:w-auto border-t lg:border-t-0 lg:border-l border-gray-100 pt-8 lg:pt-0 lg:pl-12">
                   <div class="text-center">
                       <p class="text-2xl font-black text-gray-800">{{ $connectionsCount ?? '124' }}</p>
                       <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Connects</p>
                   </div>
                   <div class="text-center">
                       <p class="text-2xl font-black text-gray-800">{{ $eventsCount ?? '8' }}</p>
                       <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Events</p>
                   </div>
                   <div class="text-center">
                       <p class="text-2xl font-black text-gray-800">{{ $yearsActive ?? '4' }}</p>
                       <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Years</p>
                   </div>
                </div>
            </div>
            <!-- Auth background mark -->
            <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-primary/5 rounded-full pointer-events-none"></div>
        </section>

        <div class="grid lg:grid-cols-3 gap-10">
            <!-- Left Info Pane -->
            <div class="lg:col-span-2 space-y-10">
                <section class="bg-white p-8 rounded-[32px] border border-gray-50 shadow-sm">
                    <h3 class="text-xl font-bold text-primary mb-6 flex items-center gap-3">
                        <i class="fa-solid fa-quote-left text-secondary text-sm"></i>
                        About & Bio
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-medium">
                        {{ $user->bio ?: 'No professional summary provided. Sharing your journey helps in mentorship and branch networking.' }}
                    </p>
                </section>

                @if($user->degrees && $user->degrees->count() > 0)
                <section class="bg-white p-8 rounded-[32px] border border-gray-50 shadow-sm">
                    <h3 class="text-xl font-bold text-primary mb-6 flex items-center gap-3">
                        <i class="fa-solid fa-graduation-cap text-secondary text-sm"></i>
                        Education & Degrees
                    </h3>
                    <div class="space-y-6">
                        @foreach($user->degrees as $deg)
                        <div class="border-l-4 border-secondary pl-4 py-1">
                            <h4 class="font-bold text-gray-800 text-sm">{{ $deg->degree_type }} in {{ $deg->course }}</h4>
                            <p class="text-xs text-gray-500 font-medium">{{ $deg->department }} • Class of {{ $deg->graduation_year }}</p>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <section class="bg-white p-8 rounded-[32px] border border-gray-50 shadow-sm">
                    <h3 class="text-xl font-bold text-primary mb-6">Contact & Socials</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="flex items-center gap-4 group">
                            <div class="w-10 h-10 bg-primary/5 rounded-xl flex items-center justify-center text-primary"><i class="fa-solid fa-envelope"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Primary Email</p>
                                <p class="text-sm font-bold text-gray-700">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <div class="w-10 h-10 bg-secondary/5 rounded-xl flex items-center justify-center text-secondary"><i class="fa-solid fa-location-dot"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Location</p>
                                <p class="text-sm font-bold text-gray-700">{{ $user->location ?? 'Lagos, Nigeria' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 group">
                             <div class="w-10 h-10 bg-primary/5 rounded-xl flex items-center justify-center text-primary"><i class="fa-solid fa-cake-candles"></i></div>
                             <div>
                                 <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Birthday</p>
                                 <p class="text-sm font-bold text-gray-700">{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d F') : 'Not Set' }}</p>
                             </div>
                         </div>
                         <div class="flex items-center gap-4 group">
                             <div class="w-10 h-10 bg-secondary/5 rounded-xl flex items-center justify-center text-secondary"><i class="fa-solid fa-phone"></i></div>
                             <div>
                                 <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Phone</p>
                                 <p class="text-sm font-bold text-gray-700">{{ $user->phone ?? 'Not Linked' }}</p>
                             </div>
                         </div>
                         <div class="flex items-center gap-4 group">
                             <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600"><i class="fa-brands fa-linkedin-in"></i></div>
                             <div>
                                 <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">LinkedIn Handle</p>
                                 <p class="text-sm font-bold text-blue-600">@<span>{{ getUsername($user->linkedin_url) }}</span></p>
                             </div>
                         </div>
                        <div class="flex items-center gap-4 group">
                            <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-800"><i class="fa-brands fa-x-twitter"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">X Platform</p>
                                <p class="text-sm font-bold text-gray-800">@<span>{{ getUsername($user->twitter_url) }}</span></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-800"><i class="fa-brands fa-facebook-f"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Facebook</p>
                                <p class="text-sm font-bold text-blue-800">@<span>{{ getUsername($user->facebook_url) }}</span></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <div class="w-10 h-10 bg-pink-50 rounded-xl flex items-center justify-center text-pink-600"><i class="fa-brands fa-instagram"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Instagram</p>
                                <p class="text-sm font-bold text-pink-600">@<span>{{ getUsername($user->instagram_url) }}</span></p>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

            <!-- Side Settings Pane -->
            <div class="space-y-10">
                @if($isOwnProfile)
                <section class="bg-primary p-8 rounded-[32px] text-white overflow-hidden relative">
                    <h3 class="text-xl font-bold mb-6 relative z-10">Account Power</h3>
                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center justify-between p-4 bg-white/10 rounded-2xl border border-white/10">
                            <span class="text-xs font-bold">Public Directory</span>
                            <div class="w-10 h-5 bg-secondary rounded-full relative"><span class="absolute right-1 top-1 w-3 h-3 bg-white rounded-full"></span></div>
                        </div>
                        <form id="notif-form" action="{{ route('profile.notifications') }}" method="POST" class="flex items-center justify-between p-4 bg-white/10 rounded-2xl border border-white/10">
                            @csrf
                            <span class="text-xs font-bold">Receive Notifications</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="receive_notifications" @if(auth()->user()->receive_notifications) checked @endif onchange="document.getElementById('notif-form').submit()" class="sr-only peer">
                                <div class="w-10 h-5 bg-white/20 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2.5px] after:left-[2.5px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-secondary"></div>
                            </label>
                        </form>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
                </section>

                <section class="p-2">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center justify-center gap-3 w-full bg-red-50 text-red-500 py-4 rounded-[32px] font-black text-xs tracking-widest hover:bg-red-500 hover:text-white transition-all transition-duration-300">
                        <i class="fa-solid fa-power-off"></i> SECURE LOGOUT
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </section>
                @else
                <section class="bg-primary p-8 rounded-[32px] text-white overflow-hidden relative">
                    <h3 class="text-xl font-bold mb-6 relative z-10">Networking</h3>
                    <div class="space-y-4 relative z-10 text-sm">
                        <div class="p-4 bg-white/10 rounded-2xl border border-white/10">
                            <span class="text-[10px] font-bold text-secondary uppercase tracking-widest block mb-1">Status</span>
                            <span class="font-bold">
                                @if($isConnected)
                                    Connected
                                @elseif($iRequested)
                                    Request Pending
                                @elseif($theyRequested)
                                    Received Request
                                @else
                                    Not Connected
                                @endif
                            </span>
                        </div>
                        <div class="p-4 bg-white/10 rounded-2xl border border-white/10">
                            <span class="text-[10px] font-bold text-secondary uppercase tracking-widest block mb-1">Member Rank</span>
                            <span class="font-bold">{{ $alumniLevel }}</span>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
                </section>
                @endif
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

<script>
    function shareIdentity() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $user->name }} | UNIBEN Alumni Lagos',
                text: 'Connect with me on the official UNIBEN Alumni Association Lagos Branch Portal.',
                url: window.location.href
            }).then(() => {
                console.log('Successfully shared');
            }).catch((error) => {
                console.log('Error sharing:', error);
            });
        } else {
            const el = document.createElement('textarea');
            el.value = window.location.href;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            alert('Profile link copied to clipboard!');
        }
    }

    @if($isBirthday)
    window.onload = function() {
        // First blast
        confetti({
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 },
            colors: ['#4A0E4E', '#D4AF37', '#ffffff']
        });

        // Continuous balloons for 5 seconds
        let duration = 5 * 1000;
        let animationEnd = Date.now() + duration;
        let defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        let interval = setInterval(function() {
            let timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            let particleCount = 50 * (timeLeft / duration);
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
        }, 250);
    };
    @endif
</script>

</body>
</html>


</body>
</html>
