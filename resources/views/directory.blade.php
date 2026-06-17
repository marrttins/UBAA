<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Directory | UNIBEN Alumni Lagos</title>
    <link rel="icon" type="image/png" href="{{ asset('images/uniben-logo.png') }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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

<div class="layout-wrapper">
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/uniben-logo.png') }}" class="w-9 h-9 rounded-full bg-black p-0.5 object-contain">
            <span class="text-primary font-bold">Network Directory</span>
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
        <!-- Editorial Header -->
        <section class="mb-12">
            <h1 class="text-4xl md:text-6xl font-black text-primary mb-4 font-headline tracking-tighter">Global Network.</h1>
            <p class="text-gray-400 max-w-xl text-sm md:text-base font-medium">Connect with fellow Great Benin alumni across the globe. Rejuvenate old bonds and build new professional alliances.</p>
        </section>

        <!-- Search & Filters -->
        <section class="grid lg:grid-cols-4 gap-4 mb-10">
            <div class="lg:col-span-3">
                <form action="{{ route('directory') }}" method="GET" class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    <input type="text" name="search" value="{{ $request->search ?? '' }}" 
                           placeholder="Search by name, degree, or company..." 
                           class="w-full bg-white border-none rounded-2xl py-4 pl-14 pr-6 shadow-sm focus:ring-2 focus:ring-primary focus:shadow-md transition-all outline-none">
                </form>
            </div>
            <button class="bg-primary text-white font-bold h-full py-4 px-8 rounded-2xl flex items-center justify-center gap-3 hover:brightness-110 active:scale-95 transition-all">
                <i class="fa-solid fa-sliders"></i> Filters
            </button>
        </section>

        <!-- Dynamic Filter Pills -->
        <div class="flex gap-3 overflow-x-auto no-scrollbar mb-12">
            <button class="bg-primary text-white px-5 py-2 rounded-full text-xs font-bold whitespace-nowrap">All Alumni</button>
            <button class="bg-white border text-gray-500 px-5 py-2 rounded-full text-xs font-semibold whitespace-nowrap">Class of 2024</button>
            <button class="bg-white border text-gray-500 px-5 py-2 rounded-full text-xs font-semibold whitespace-nowrap">Engineering</button>
            <button class="bg-white border text-gray-500 px-5 py-2 rounded-full text-xs font-semibold whitespace-nowrap">Medicine</button>
            <button class="bg-white border text-gray-500 px-5 py-2 rounded-full text-xs font-semibold whitespace-nowrap">Law</button>
        </div>

        <!-- Directory Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($users as $user)
            @php
               $iRequested = isset($myConnections[$user->id]);
               $theyRequested = isset($theirConnections[$user->id]);
               $isConnected = ($iRequested && $myConnections[$user->id]->status === 'accepted') || ($theyRequested && $theirConnections[$user->id]->status === 'accepted');
            @endphp
            <div class="bg-white p-6 rounded-[32px] border border-gray-50 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                <div class="flex items-start gap-6 relative z-10">

                    <a href="{{ route('profile.show', $user->id) }}" class="relative shrink-0 block hover:opacity-90 transition-opacity">
                        <img src="{{ asset($user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=4A0E4E&color=fff') }}" 
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4A0E4E&color=fff'" 
                             class="w-20 h-20 rounded-3xl object-cover bg-gray-50 border-2 border-gray-100">

                        @if($user->membership_type)
                        <div class="absolute -bottom-2 -right-2 bg-secondary text-primary w-8 h-8 rounded-xl border-4 border-white flex items-center justify-center text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        @endif
                    </a>
                    
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('profile.show', $user->id) }}" class="hover:underline hover:text-secondary transition-colors">
                            <h3 class="text-xl font-bold text-primary mb-1 truncate">{{ $user->name }}</h3>
                        </a>
                        <p class="text-[10px] font-black text-secondary tracking-widest uppercase mb-3">'{{ substr($user->graduation_year ?? 'N/A', -2) }} • {{ $user->degree ?? 'Alumnus' }}</p>
                        
                        <div class="space-y-2 mb-6">
                           <div class="flex items-center gap-2 text-xs text-gray-400">
                               <i class="fa-solid fa-briefcase text-[10px] text-gray-300"></i>
                               <span class="truncate font-semibold text-gray-600">{{ $user->job_title ?? 'Alumnus' }} at {{ $user->company ?? 'Lagos' }}</span>
                           </div>
                           <div class="flex items-center gap-2 text-xs text-gray-400">
                               <i class="fa-solid fa-location-dot text-[10px] text-gray-300"></i>
                               <span class="truncate">{{ $user->location ?? 'Nigeria' }}</span>
                           </div>
                        </div>

                        <div class="flex gap-2">
                           <form action="{{ route('directory.connect') }}" method="POST">
                               @csrf
                               <input type="hidden" name="user_id" value="{{ $user->id }}">
                               @if($isConnected)
                                    <button type="button" class="bg-gray-50 text-gray-400 px-6 py-2.5 rounded-xl text-xs font-bold cursor-default">CONNECTED</button>
                               @elseif($iRequested)
                                    <button type="button" class="bg-secondary/10 text-secondary px-6 py-2.5 rounded-xl text-xs font-bold cursor-default">PENDING</button>
                               @elseif($theyRequested)
                                    <button type="submit" class="bg-secondary text-primary px-6 py-2.5 rounded-xl text-xs font-bold hover:brightness-110 active:scale-95 transition-all shadow-lg">ACCEPT</button>
                               @else
                                    <button type="submit" class="bg-primary text-white px-6 py-2.5 rounded-xl text-xs font-bold hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-primary/10">CONNECT</button>
                               @endif
                           </form>

                           <a href="mailto:{{ $user->email }}" class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-primary border border-gray-100 hover:bg-primary hover:text-white transition-colors">
                               <i class="fa-solid fa-envelope"></i>
                           </a>
                        </div>
                    </div>
                </div>
                <!-- Background decoration -->
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-primary/5 rounded-full pointer-events-none group-hover:scale-150 transition-transform"></div>
            </div>
            @endforeach
        </div>

        @if($users->isEmpty())
        <div class="py-20 text-center bg-white rounded-[32px] border border-dashed border-gray-200">
            <i class="fa-solid fa-user-slash text-5xl text-gray-200 mb-6"></i>
            <h4 class="text-xl font-bold text-gray-400">No members match your search</h4>
        </div>
        @endif

        <div class="mt-16 flex justify-center">
            <button class="flex items-center gap-2 text-primary font-black text-sm uppercase tracking-widest group">
                LOAD MORE BRANCH MEMBERS <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
            </button>
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

</body>
</html>
