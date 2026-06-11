<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Events | UNIBEN Alumni Lagos</title>
    <link rel="icon" type="image/png" href="{{ asset('images/uniben-logo.png') }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
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
                  "surface": "#ffffff",
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

        /* Top Bar */
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

        /* Sidebar - Hidden on mobile */
        .sidebar {
            display: none;
            width: var(--sidebar-width);
            background: #fff;
            height: calc(100vh - 73px); /* Subtract top bar height approx */
            position: sticky;
            top: 73px;
            border-right: 1px solid #e5e7eb;
            padding: 24px;
            flex-direction: column;
            gap: 8px;
        }

        /* Bottom Nav - Shown on mobile */
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

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 24px;
            max-width: 100%;
            margin: 0 auto;
            width: 100%;
        }

        @media (min-width: 1024px) {
            .layout-wrapper { flex-direction: row; flex-wrap: wrap; }
            .sidebar { display: flex; }
            .bottom-nav { display: none; }
            .main-content { padding: 40px; }
            /* Force top bar to span full width above sidebar/content */
            .top-bar { width: 100%; }
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="font-body">

<div class="layout-wrapper">
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/uniben-logo.png') }}" alt="Logo" class="w-9 h-9 rounded-full border border-gray-100 bg-black p-0.5 object-contain">
            <span class="text-primary font-bold text-base">UNIBEN Alumni <small class="text-[10px] text-secondary block -mt-1">Lagos Branch</small></span>
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

    <!-- Sidebar (PC) -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content mb-24 lg:mb-0">
        <!-- Featured Event -->
        <section class="mb-12">
            <div class="relative w-full h-[300px] md:h-[450px] rounded-3xl overflow-hidden shadow-xl">
                <img src="https://images.unsplash.com/photo-1540575861501-7ad060e1c27b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80" alt="Featured" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 md:p-12 text-white">
                    <span class="bg-secondary text-primary px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider mb-4 inline-block">Flagship Event</span>
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-4 font-headline">Lagos Branch Annual Gala 2026</h1>
                    <div class="flex flex-wrap gap-4 text-sm opacity-90">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-calendar"></i> Dec 20, 2026</span>
                        <span class="flex items-center gap-2"><i class="fa-solid fa-location-dot"></i> Victoria Island, Lagos</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Category Tabs -->
        <div class="flex gap-3 mb-8 overflow-x-auto no-scrollbar pb-2">
            <button class="bg-primary text-white px-6 py-2 rounded-full text-sm font-bold whitespace-nowrap">All Events</button>
            <button class="bg-white text-gray-500 border border-gray-100 px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap hover:bg-gray-50">Branch Meetings</button>
            <button class="bg-white text-gray-500 border border-gray-100 px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap hover:bg-gray-50">Seminars</button>
            <button class="bg-white text-gray-500 border border-gray-100 px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap hover:bg-gray-50">Hangouts</button>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($events as $event)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-gray-50 group">
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ $event->image_url ? (str_starts_with($event->image_url, 'http') ? $event->image_url : asset($event->image_url)) : 'https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-[10px] font-bold text-primary">{{ $event->fee && $event->fee > 0 ? '₦' . number_format($event->fee, 0) : 'FREE' }}</div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[10px] font-bold text-secondary uppercase">{{ $event->category ?? 'Lagos Event' }}</span>
                        <span class="text-[11px] font-medium text-gray-500">{{ $event->event_month }} {{ $event->event_day }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4 group-hover:text-primary transition-colors">{{ $event->title }}</h3>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                        <i class="fa-solid fa-map-pin text-[12px]"></i>
                        <span>{{ $event->location_name }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('events.detail', $event->id) }}" class="text-xs font-bold text-primary hover:underline">Details</a>
                        <a href="{{ route('events.detail', $event->id) }}#rsvp" class="bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-opacity-90 transition-all text-center">RSVP Now</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Quick Meeting RSVP -->
        <div class="mt-16 bg-primary rounded-3xl p-8 md:p-12 text-white overflow-hidden relative">
            <div class="relative z-10 grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-4">Branch Physics Meeting</h2>
                    <p class="opacity-80 text-sm mb-8 leading-relaxed">Join us every last Sunday of the month at the branch secretariat. An afternoon of networking, welfare updates, and refreshments.</p>
                    <div class="flex gap-8">
                        <div>
                            <p class="text-[10px] text-secondary font-bold uppercase mb-1">Schedule</p>
                            <p class="font-bold">Last Sundays @ 4PM</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-6 border border-white/20">
                    <h4 class="font-bold mb-4">Express Check-in</h4>
                    <form onsubmit="alert('Your express check-in RSVP has been noted. We look forward to seeing you at the meeting!'); return false;">
                        <select class="w-full bg-white/10 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-secondary mb-4">
                            <option class="text-dark">Select Upcoming Meeting</option>
                            <option class="text-dark">Oct 2024 Physical Meeting</option>
                        </select>
                        <button type="submit" class="w-full bg-secondary text-primary font-bold py-3 rounded-xl hover:brightness-110 transition-all">RSVP Attendance</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

</body>
</html>
