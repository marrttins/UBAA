<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard | UNIBEN Alumni Lagos</title>
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
            overflow-x: hidden;
            width: 100vw;
        }

        .layout-wrapper {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 100vw;
            min-height: 100vh;
            overflow-x: hidden;
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
            max-width: 100%;
            overflow-x: hidden;
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
            <span class="text-primary font-bold">Member Portal</span>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('notifications') }}" class="relative text-primary text-xl">
                <i class="fa-solid fa-bell"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[8px] font-black flex items-center justify-center rounded-full border-2 border-white animation-pulse">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
                @endif
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors text-xl" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </header>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content mb-24 lg:mb-0">
        <!-- Welcome Banner -->
        <section class="bg-gradient-to-r from-primary to-primary-light rounded-[24px] md:rounded-[40px] p-8 md:p-14 text-white mb-10 relative overflow-hidden shadow-2xl">
           <div class="relative z-10">
               <span class="inline-block px-3 py-1 bg-white/10 backdrop-blur rounded-full text-[10px] md:text-xs font-black uppercase tracking-widest mb-4">MEMBER CENTER</span>
               <h2 class="text-3xl md:text-5xl font-black mb-3 tracking-tight">Welcome back, {{ auth()->check() ? explode(' ', auth()->user()->name)[0] : 'Alumnus' }}!</h2>
               <p class="text-white/60 text-sm md:text-base font-medium max-w-lg leading-relaxed">Class of {{ auth()->user()->graduation_year ?? 'Not Set' }} • You are an active member of the UNIBEN Alumni Association Lagos Branch.</p>
           </div>
           <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
           <div class="absolute -left-10 -top-10 w-40 h-40 bg-secondary/10 rounded-full blur-2xl"></div>
        </section>

        <!-- Quick Actions -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
            <a href="{{ route('payments') }}" class="bg-white p-6 md:p-8 rounded-[32px] shadow-sm border border-gray-100 flex flex-col items-center hover:scale-[1.02] hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-2xl bg-primary/5 flex items-center justify-center text-primary text-2xl mb-4"><i class="fa-solid fa-money-bill-wave"></i></div>
                <span class="text-[11px] font-black uppercase tracking-widest text-gray-500">Pay Dues</span>
            </a>
            <a href="{{ route('directory') }}" class="bg-white p-6 md:p-8 rounded-[32px] shadow-sm border border-gray-100 flex flex-col items-center hover:scale-[1.02] hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-2xl bg-secondary/5 flex items-center justify-center text-secondary text-2xl mb-4"><i class="fa-solid fa-user-group"></i></div>
                <span class="text-[11px] font-black uppercase tracking-widest text-gray-500">Directory</span>
            </a>
            <a href="{{ route('events') }}" class="bg-white p-6 md:p-8 rounded-[32px] shadow-sm border border-gray-100 flex flex-col items-center hover:scale-[1.02] hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center text-green-600 text-2xl mb-4"><i class="fa-solid fa-calendar-day"></i></div>
                <span class="text-[11px] font-black uppercase tracking-widest text-gray-500">Events</span>
            </a>
            <a href="{{ route('cooperative') }}" class="bg-white p-6 md:p-8 rounded-[32px] shadow-sm border border-gray-100 flex flex-col items-center hover:scale-[1.02] hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 text-2xl mb-4"><i class="fa-solid fa-handshake"></i></div>
                <span class="text-[11px] font-black uppercase tracking-widest text-gray-500">Cooperative</span>
            </a>
        </div>

        <div class="grid lg:grid-cols-3 gap-10 w-full max-w-full">
            <!-- Left/Center Column -->
            <div class="lg:col-span-2 space-y-10 w-full max-w-full overflow-hidden">
                <!-- News Feed -->
                <section class="max-w-full overflow-hidden">
                    <div class="flex justify-between items-end mb-6">
                        <h3 class="text-xl font-bold text-primary">Member News</h3>
                        <a href="{{ route('news.index') }}" class="text-xs font-bold text-secondary uppercase">All News</a>
                    </div>
                    <div class="flex gap-6 overflow-x-auto no-scrollbar pb-6 -mx-4 px-4 md:mx-0 md:px-0">
                        @foreach($news as $item)
                        <a href="{{ route('news.show', $item->slug ?? $item->id) }}" class="min-w-[280px] md:min-w-[340px] bg-white rounded-[32px] overflow-hidden shadow-sm border border-gray-100 group hover:shadow-lg transition-all">
                            <div class="h-44 md:h-52 overflow-hidden relative">
                                <img src="{{ $item->image_url ?? 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute top-4 left-4 bg-primary text-white px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest">{{ $item->category }}</div>
                            </div>
                            <div class="p-6 md:p-8">
                                <h4 class="font-bold text-gray-800 leading-snug line-clamp-2 md:h-14 md:text-lg">{{ $item->title }}</h4>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mt-4 tracking-widest">{{ $item->created_at->format('d M, Y') }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </section>

                <!-- Donations -->
                <section class="bg-white p-6 md:p-8 rounded-[32px] shadow-sm border border-gray-50 w-full overflow-hidden">
                    <h3 class="text-xl font-bold text-primary mb-6">Branch Project Support</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        @forelse($projects as $project)
                        <div class="p-5 md:p-6 bg-gray-50 rounded-2xl">
                            <div class="flex items-center gap-4 mb-6">
                               <div class="w-12 h-12 md:w-14 md:h-14 bg-secondary flex items-center justify-center text-white text-xl md:text-2xl rounded-2xl shadow-lg shadow-secondary/20">
                                   <i class="fa-solid {{ $project->icon ?? 'fa-hotel' }}"></i>
                               </div>
                               <div class="min-w-0 flex-1">
                                   <h4 class="font-bold text-gray-800 text-sm md:text-base truncate">{{ $project->title }}</h4>
                                   <p class="text-[10px] text-gray-400">Lagos Branch Special Project</p>
                               </div>
                            </div>
                            <div class="space-y-3">
                                @php
                                    $percentage = $project->goal_amount > 0 ? min(100, round(($project->raised_amount / $project->goal_amount) * 100)) : 0;
                                @endphp
                                <div class="flex justify-between text-xs font-bold text-gray-500">
                                    <span>PROGRESS</span>
                                    <span>{{ $percentage }}% Reach</span>
                                </div>
                                <div class="w-full bg-gray-200 h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-secondary h-full rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                            <button onclick="window.location='{{ route('donate') }}'" class="w-full mt-8 bg-primary text-white py-3.5 rounded-xl font-extrabold text-[11px] tracking-widest uppercase">JOIN THE DONORS</button>
                        </div>
                        @empty
                        <div class="p-10 bg-gray-50 rounded-2xl text-center col-span-2">
                            <i class="fa-solid fa-heart-circle-exclamation text-gray-200 text-4xl mb-4"></i>
                            <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">No active projects at the moment</p>
                        </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- Right Column -->
            <div class="space-y-10 w-full max-w-full overflow-hidden font-body">
                <!-- Personality of the Week -->
                @if($personality)
                <section class="bg-gradient-to-br from-primary to-primary-dark p-8 rounded-[40px] text-white relative overflow-hidden shadow-2xl group">
                    <div class="relative z-10">
                        <span class="inline-block px-3 py-1 bg-white/10 backdrop-blur rounded-full text-[9px] font-black uppercase tracking-widest mb-6">PERSONALITY OF THE WEEK</span>
                        <div class="flex items-center gap-5 mb-6">
                            <div class="w-16 h-16 rounded-2xl ring-2 ring-secondary/30 p-1 flex-shrink-0">
                                <img src="{{ $personality->avatar_url ? url($personality->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($personality->name).'&background=D4AF37&color=4A0E4E' }}" class="w-full h-full object-cover rounded-xl shadow-lg">
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-black text-lg line-clamp-1 leading-tight mb-1">{{ $personality->name }}</h4>
                                <p class="text-[9px] font-bold text-secondary uppercase tracking-widest">{{ $personality->calculateAlumniLevel() }}</p>
                            </div>
                        </div>
                        <p class="text-xs text-white/70 line-clamp-3 mb-6 font-medium italic">"{{ $personality->bio }}"</p>
                        <a href="{{ route('directory', ['search' => $personality->name]) }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-secondary hover:translate-x-1 transition-transform">
                            VIEW PROFILE <i class="fa-solid fa-arrow-right-long"></i>
                        </a>
                    </div>
                    <!-- Decorative patterns -->
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                    <div class="absolute -left-10 -top-10 w-20 h-20 bg-secondary/10 rounded-full blur-xl"></div>
                </section>
                @endif

                <!-- Birthday Celebrants -->
                <section class="bg-white p-8 rounded-[40px] shadow-sm border border-gray-50 relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-8 relative z-10">
                        <h3 class="text-xl font-headline font-black text-primary">Celebrants</h3>
                        <div class="w-10 h-10 rounded-2xl bg-secondary/10 flex items-center justify-center text-secondary">
                            <i class="fa-solid fa-cake-candles"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-4 relative z-10">
                        @forelse($celebrants as $celebrant)
                        <div class="flex items-center gap-4 p-4 rounded-3xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100 group/item">
                            <div class="relative">
                                <img src="{{ $celebrant->avatar_url ? url($celebrant->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($celebrant->name).'&background=random' }}" class="w-12 h-12 rounded-full object-cover shadow-sm bg-gray-100">
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-primary border-2 border-white rounded-full flex items-center justify-center text-[8px] text-white">🎉</div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h5 class="text-xs font-black text-gray-800 line-clamp-1 truncate">{{ $celebrant->name }}</h5>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">
                                    {{ \Carbon\Carbon::parse($celebrant->date_of_birth)->isToday() ? 'TODAY!' : \Carbon\Carbon::parse($celebrant->date_of_birth)->format('jS M') }}
                                </p>
                            </div>
                            <button class="w-8 h-8 rounded-full bg-primary/5 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                                <i class="fa-solid fa-heart text-[10px]"></i>
                            </button>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <i class="fa-solid fa-gift text-gray-100 text-3xl mb-3"></i>
                            <p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">No birthdays this week</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Decorative Background -->
                    <div class="absolute -right-4 top-20 text-gray-50 opacity-10 select-none pointer-events-none">
                        <i class="fa-solid fa-cake-candles text-9xl"></i>
                    </div>
                </section>

                <!-- Upcoming Events -->
                <section>
                    <h3 class="text-xl font-bold text-primary mb-6">Next Events</h3>
                    <div class="space-y-4">
                        @foreach($events as $event)
                        <div class="bg-white p-4 rounded-3xl border border-gray-50 flex items-center gap-4 hover:shadow-md transition-all group">
                            <div class="w-14 h-14 bg-gray-50 rounded-2xl flex flex-col items-center justify-center shrink-0 border border-gray-100">
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">{{ $event->event_month }}</span>
                                <span class="text-xl font-black text-primary leading-none">{{ $event->event_day }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-800 truncate">{{ $event->title }}</h4>
                                <p class="text-[10px] text-gray-400 truncate flex items-center gap-1 mt-1"><i class="fa-solid fa-map-pin text-secondary"></i> {{ $event->location_name }}</p>
                            </div>
                            <button onclick="window.location='{{ route('events.detail', $event->id) }}'" class="w-8 h-8 rounded-full bg-primary/5 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                        </div>
                        @endforeach
                    </div>
                </section>

                <!-- Job Alerts -->
                <section>
                    <h3 class="text-xl font-bold text-primary mb-6">Opportunities</h3>
                    <div class="space-y-4">
                        @foreach($jobs as $job)
                        <div class="bg-primary p-6 rounded-[32px] text-white relative overflow-hidden group">
                           <div class="relative z-10">
                               <h4 class="font-bold text-sm mb-1 leading-tight">{{ $job->title }}</h4>
                               <p class="text-[10px] opacity-70 mb-6 font-semibold uppercase tracking-wide">{{ $job->company }}</p>
                               <div class="flex justify-between items-center">
                                   <div class="flex -space-x-2">
                                       <img src="https://i.pravatar.cc/100?u=1" class="w-6 h-6 rounded-full border-2 border-primary">
                                       <img src="https://i.pravatar.cc/100?u=2" class="w-6 h-6 rounded-full border-2 border-primary">
                                   </div>
                                   <a href="{{ $job->link ?? route('jobs') }}" class="text-[10px] font-bold border-b border-white border-dashed">Apply Now</a>
                               </div>
                           </div>
                           <div class="absolute -right-4 -top-4 w-12 h-12 bg-white/5 rounded-full blur-xl group-hover:scale-150 transition-transform"></div>
                        </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

</body>
</html>
