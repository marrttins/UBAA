<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opportunities | UNIBEN Alumni Lagos</title>
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
            <span class="text-primary font-bold">Opportunities</span>
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
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <section class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="max-w-xl">
                    <h1 class="text-4xl md:text-6xl font-black text-primary mb-4 font-headline tracking-tighter">Careers hub.</h1>
                    <p class="text-gray-400 text-sm md:text-base font-medium">Exclusive job openings and career advancements within the Great Benin alumni network.</p>
                </div>
                <a href="{{ route('jobs.create') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs tracking-widest shadow-xl shadow-primary/10 hover:brightness-110 active:scale-95 transition-all uppercase">POST OPPORTUNITY</a>
            </section>

            <!-- Search -->
            <section class="mb-10">
                <div class="relative max-w-2xl">
                    <i class="fa-solid fa-magnifying-glass absolute left-6 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    <input type="text" placeholder="Search roles, companies or keywords..." class="w-full bg-white border-none rounded-2xl py-5 pl-16 pr-6 shadow-sm focus:ring-2 focus:ring-primary focus:shadow-md transition-all outline-none text-sm font-medium">
                </div>
            </section>

            <div class="grid lg:grid-cols-4 gap-10">
                <!-- Filters Column -->
                <div class="lg:col-span-1 space-y-8">
                    <div>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Job Type</h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="w-5 h-5 rounded-md border-2 border-gray-200 group-hover:border-primary transition-colors flex items-center justify-center">
                                    <div class="w-2 h-2 bg-primary rounded-sm opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-600">Full Time</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="w-5 h-5 rounded-md border-2 border-gray-200 group-hover:border-primary transition-colors flex items-center justify-center">
                                    <div class="w-2 h-2 bg-primary rounded-sm opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-600">Remote Only</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="w-5 h-5 rounded-md border-2 border-gray-200 group-hover:border-primary transition-colors flex items-center justify-center">
                                    <div class="w-2 h-2 bg-primary rounded-sm opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-600">Contract</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Jobs Column -->
                <div class="lg:col-span-3 space-y-6">
                    @forelse($jobs as $job)
                    <div class="bg-white p-6 md:p-8 rounded-[32px] border border-gray-50 shadow-sm hover:shadow-xl transition-all group flex flex-col md:flex-row gap-6 relative overflow-hidden">
                        <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100 overflow-hidden">
                            @if($job->logo_url)
                                <img src="{{ $job->logo_url }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-primary font-black text-xl italic">{{ substr($job->company, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-col md:flex-row justify-between items-start mb-4 gap-2">
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800 group-hover:text-primary transition-colors">{{ $job->title }}</h4>
                                    <p class="text-xs font-bold text-secondary uppercase tracking-wider mb-2">{{ $job->company }}</p>
                                </div>
                                <span class="bg-primary/5 text-primary text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">{{ $job->environment ?? 'Office' }}</span>
                            </div>
                            <div class="flex flex-wrap gap-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-50 pb-6">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-location-dot"></i> {{ $job->location ?? 'Nigeria' }}</span>
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-money-bill-wave"></i> {{ $job->salary_range ?? 'Unspecified' }}</span>
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-calendar-xmark text-red-400"></i> Deadline: {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('M d, Y') : 'Ongoing' }}</span>
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-calendar"></i> Posted {{ $job->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-xs text-gray-400 font-medium">Expertise required in core disciplines.</p>
                                <a href="{{ route('jobs.show', $job->id) }}" class="bg-primary text-white px-6 py-2.5 rounded-xl text-xs font-bold hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-primary/10 uppercase tracking-widest">DETAILS</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-20 bg-gray-50 rounded-[32px] border border-dashed border-gray-200 text-center">
                        <i class="fa-solid fa-briefcase text-4xl text-gray-200 mb-4"></i>
                        <p class="text-gray-400 font-bold">No active opportunities found</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

</body>
</html>
