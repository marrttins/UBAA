<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni News | UNIBEN Alumni Lagos</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script id="tailwind-config">
          tailwind.config = {
            darkMode: "class",
            theme: {
              extend: {
                colors: {
                  "primary": "#4A0E4E",
                  "primary-light": "#5A1B5E",
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
            <a href="{{ route('dashboard') }}" class="lg:hidden text-primary text-xl"><i class="fa-solid fa-arrow-left"></i></a>
            <img src="{{ asset('images/uniben-logo.png') }}" class="w-9 h-9 rounded-full bg-black p-0.5 object-contain">
            <span class="text-primary font-bold">Alumni News</span>
        </div>
        <button class="text-primary text-xl"><i class="fa-solid fa-bell"></i></button>
    </header>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content mb-24 lg:mb-0">
        <!-- Header -->
        <section class="mb-12">
            <h1 class="text-4xl md:text-6xl font-black text-primary mb-4 font-headline tracking-tighter">Branch Updates.</h1>
            <p class="text-gray-400 max-w-xl text-sm md:text-base font-medium">The latest stories, achievements, and notices from the UNIBEN Alumni Association Lagos Branch.</p>
        </section>

        <!-- News Categories -->
        <div class="flex gap-3 overflow-x-auto no-scrollbar mb-10 overflow-visible">
            <button class="bg-primary text-white px-6 py-2 rounded-full text-xs font-bold whitespace-nowrap shadow-lg shadow-primary/20">All News</button>
            <button class="bg-white border border-gray-100 text-gray-500 px-6 py-2 rounded-full text-xs font-semibold whitespace-nowrap hover:bg-gray-50">Branch Events</button>
            <button class="bg-white border border-gray-100 text-gray-500 px-6 py-2 rounded-full text-xs font-semibold whitespace-nowrap hover:bg-gray-50">Member Spotlights</button>
            <button class="bg-white border border-gray-100 text-gray-500 px-6 py-2 rounded-full text-xs font-semibold whitespace-nowrap hover:bg-gray-50">Announcements</button>
        </div>

        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
            @foreach($news as $item)
            <a href="{{ route('news.show', $item->slug ?? $item->id) }}" class="bg-white rounded-[32px] overflow-hidden shadow-sm border border-gray-50 group hover:shadow-xl hover:scale-[1.01] transition-all duration-300">
                <div class="h-56 md:h-64 overflow-hidden relative">
                    <img src="{{ $item->image_url ?? 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1.5 rounded-full text-[10px] font-black text-primary uppercase tracking-widest">{{ $item->category }}</div>
                </div>
                <div class="p-8">
                    <h3 class="text-xl font-bold text-gray-800 leading-snug mb-4 group-hover:text-primary transition-colors line-clamp-3 md:h-24">{{ $item->title }}</h3>
                    <div class="flex items-center justify-between text-gray-400">
                        <span class="text-[10px] font-bold uppercase tracking-widest flex items-center gap-2">
                            <i class="fa-solid fa-calendar-day text-secondary"></i>
                            {{ $item->created_at->format('d M, Y') }}
                        </span>
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        @if($news->isEmpty())
        <div class="py-24 text-center bg-white rounded-[40px] border border-dashed border-gray-200">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-newspaper text-3xl text-gray-200"></i>
            </div>
            <h4 class="text-xl font-bold text-gray-400">No news articles found</h4>
            <p class="text-xs text-gray-300 mt-2 font-medium">Check back later for recent branch updates.</p>
        </div>
        @endif

        <div class="mt-20 flex justify-center">
            <button class="flex items-center gap-3 bg-white border border-gray-100 px-10 py-4 rounded-2xl text-primary font-black text-xs uppercase tracking-widest hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm">
                LOAD MORE ARTICLES <i class="fa-solid fa-rotate-right"></i>
            </button>
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

</body>
</html>
