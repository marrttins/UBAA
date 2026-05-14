<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} | UNIBEN Alumni Lagos</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
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
            height: calc(100vh - 73px);
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
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
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

        .nav-item i {
            font-size: 20px;
        }

        .nav-item span {
            font-size: 9px;
            font-weight: 700;
        }

        .sidebar .nav-item span {
            font-size: 14px;
        }

        .main-content {
            flex: 1;
            padding: 24px;
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
        }

        /* Event Specific Styles */
        .event-feature-box {
            background: white;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            margin-bottom: 40px;
        }

        .event-img {
            width: 100%;
            height: 350px;
            object-fit: cover;
        }

        @media (min-width: 1024px) {
            .layout-wrapper {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .sidebar {
                display: flex;
            }

            .bottom-nav {
                display: none;
            }

            .main-content {
                padding: 40px;
                margin: 0;
            }
        }
    </style>
</head>

<body class="font-body">

    <div class="layout-wrapper">
        <!-- Top Bar -->
        <header class="top-bar">
            <div class="flex items-center gap-4">
                <a href="{{ url()->previous() }}" class="text-primary text-lg"><i
                        class="fa-solid fa-arrow-left"></i></a>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/uniben-logo.png') }}"
                        class="w-9 h-9 rounded-full bg-black p-0.5 object-contain">
                    <span class="text-primary font-bold">Event Details</span>
                </div>
            </div>
            <button class="text-primary text-xl"><i class="fa-solid fa-bell"></i></button>
        </header>

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="main-content mb-24 lg:mb-0">
            <div class="event-feature-box">
                <img src="{{ $event->image_url ? (str_starts_with($event->image_url, 'http') ? $event->image_url : asset($event->image_url)) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80' }}"
                    alt="{{ $event->title }}" class="event-img">
                <div class="p-8 md:p-12">
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="bg-secondary/20 text-secondary px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest">Ongoing
                            RSVP</span>
                        <span
                            class="text-gray-400 text-xs font-semibold">{{ $event->category ?? 'Lagos Branch' }}</span>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-extrabold text-primary mb-12 font-headline leading-tight">
                        {{ $event->title }}</h1>

                    <div class="grid md:grid-cols-3 gap-8 mb-12">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-primary text-xl shadow-sm border border-gray-100">
                                <i class="fa-regular fa-calendar-check"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Date & Time</p>
                                <p class="font-bold text-sm text-gray-800">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">Starts @ {{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-primary text-xl shadow-sm border border-gray-100">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Venue</p>
                                <p class="font-bold text-sm text-gray-800">{{ $event->location_name }}</p>

                             </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-primary text-xl shadow-sm border border-gray-100">
                                <i class="fa-solid fa-ticket"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Admission</p>
                                <p class="font-bold text-sm text-gray-800">{{ $event->fee ?? 'FREE' }}</p>
                                <p class="text-xs text-gray-500">For Active Members</p>
                            </div>
                        </div>
                    </div>

                    <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed pt-12 border-t border-gray-50">
                        <p class="mb-6">Welcome to the official {{ $event->title }}. This event is specifically curated
                            for our distinguished members to reconnect, network, and discuss the progress of our great
                            branch.</p>
                        <p>Join us as we explore new opportunities for our alumni community and the various projects
                            currently being implemented to support our alma mater.</p>
                    </div>

                    <div id="rsvp" class="mt-12 p-8 bg-gray-50 rounded-2xl">
                        <h3 class="text-xl font-bold text-primary mb-4">Reserve Your Seat</h3>
                        
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ $event->fee > 0 ? route('payments') : route('events.rsvp', $event) }}" method="{{ $event->fee > 0 ? 'GET' : 'POST' }}">
                            @if(!$event->fee || $event->fee <= 0)
                                @csrf
                            @endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Full Name</label>
                                    <input type="text" name="name" value="{{ auth()->check() ? auth()->user()->name : '' }}" class="w-full border-gray-200 rounded-lg" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Email Address</label>
                                    <input type="email" name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}" class="w-full border-gray-200 rounded-lg" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Phone Number (Optional)</label>
                                    <input type="text" name="phone" value="{{ auth()->check() ? auth()->user()->phone : '' }}" class="w-full border-gray-200 rounded-lg">
                                </div>
                            </div>

                            @if($event->fee > 0)
                                <input type="hidden" name="purpose" value="Event Ticket: {{ $event->title }}">
                                <input type="hidden" name="amount" value="{{ $event->fee }}">
                                <div class="mb-4">
                                    <p class="text-sm font-bold text-gray-700">Ticket Price: ₦{{ number_format($event->fee, 0) }}</p>
                                    <p class="text-xs text-gray-500">You will be redirected to the payment gateway to complete your reservation.</p>
                                </div>
                            @else
                                <div class="mb-4">
                                    <p class="text-sm font-bold text-green-600">This event is FREE.</p>
                                </div>
                            @endif

                            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:shadow-primary/20 hover:scale-[1.02] transition-all">
                                {{ $event->fee > 0 ? 'PROCEED TO PAYMENT' : 'CONFIRM FREE RESERVATION' }}
                            </button>
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