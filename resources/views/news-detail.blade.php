<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }} | UNIBEN Alumni Lagos</title>
    <link rel="icon" type="image/png" href="{{ asset('images/uniben-logo.png') }}">
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
        .article-content { line-height: 1.8; }
        .article-content p { margin-bottom: 1.5rem; color: #4b5563; }
    </style>
</head>
<body class="font-body">

<div class="layout-wrapper">
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="flex items-center gap-3">
            <a href="{{ url()->previous() }}" class="lg:hidden text-primary text-xl"><i class="fa-solid fa-arrow-left"></i></a>
            <img src="{{ asset('images/uniben-logo.png') }}" class="w-9 h-9 rounded-full bg-black p-0.5 object-contain">
            <span class="text-primary font-bold">News Detail</span>
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
        <div class="max-w-4xl mx-auto">
            <!-- Article Header -->
            <section class="mb-10 text-center md:text-left">
                <div class="inline-block bg-secondary/10 text-secondary px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest mb-6 border border-secondary/10">{{ $news->category }}</div>
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-primary mb-6 font-headline tracking-tighter leading-tight">{{ $news->title }}</h1>
                <div class="flex flex-wrap justify-center md:justify-start items-center gap-6 text-gray-400 text-xs font-bold uppercase tracking-widest">
                    <span class="flex items-center gap-2"><i class="fa-regular fa-clock text-secondary"></i> {{ $news->created_at->diffForHumans() }}</span>
                    <span class="flex items-center gap-2"><i class="fa-solid fa-user-pen text-secondary"></i> Admin Desk</span>
                    <span class="flex items-center gap-2"><i class="fa-solid fa-location-dot text-secondary"></i> Lagos Branch</span>
                </div>
            </section>

            <!-- Featured Image -->
            <div class="rounded-[32px] md:rounded-[48px] overflow-hidden shadow-2xl mb-12 h-[300px] md:h-[500px]">
                <img src="{{ $news->image_url ?? 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200' }}" class="w-full h-full object-cover">
            </div>

            <!-- Article Content -->
            <div class="bg-white p-8 md:p-16 rounded-[40px] shadow-sm border border-gray-50 mb-12">
                <div class="article-content text-base md:text-lg">
                    {!! nl2br(e($news->content)) !!}
                </div>
                
                <!-- Share Section -->
                <div class="mt-16 pt-10 border-t border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Share Entry:</span>
                        <div class="flex gap-3">
                            <button class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"><i class="fa-brands fa-facebook-f"></i></button>
                            <button class="w-10 h-10 rounded-full bg-gray-50 text-gray-800 flex items-center justify-center hover:bg-black hover:text-white transition-all"><i class="fa-brands fa-x-twitter"></i></button>
                            <button class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition-all"><i class="fa-brands fa-whatsapp"></i></button>
                        </div>
                    </div>
                    <a href="{{ route('news.index') }}" class="text-[10px] font-black text-primary border-b-2 border-primary/20 hover:border-primary transition-all pb-1 uppercase tracking-widest">Return to all news</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

</body>
</html>
