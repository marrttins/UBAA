<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | UBAA Lagos</title>
    <link rel="icon" type="image/png" href="{{ asset('images/uniben-logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4A0E4E;
            --primary-dark: #370a3a;
            --secondary: #D4AF37;
            --bg-body: #f8f9fa;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-body); }
        .sidebar { background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%); }
        .nav-link { transition: all 0.3s; border-radius: 12px; margin: 4px 12px; }
        .nav-link.active { background: rgba(255, 255, 255, 0.1); border-left: 4px solid var(--secondary); color: var(--secondary); }
        .nav-link:hover:not(.active) { background: rgba(255, 255, 255, 0.05); transform: translateX(5px); }
        .card { border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); }

        @media (min-width: 768px) {
            #adminSidebar {
                transform: translateX(0);
            }
            #adminSidebar.collapsed {
                transform: translateX(-100%);
            }
            #mainContent {
                padding-left: 16rem;
            }
            #mainContent.expanded {
                padding-left: 0;
            }
        }
        @media (max-width: 767px) {
            #adminSidebar {
                transform: translateX(-100%);
            }
            #adminSidebar.open {
                transform: translateX(0);
            }
        }
    </style>
    @yield('extra_css')
</head>
<body class="text-gray-800 antialiased">
    <div class="flex h-screen overflow-hidden relative">
        <!-- Sidebar Backdrop -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"></div>

        <!-- Sidebar -->
        <aside id="adminSidebar" class="sidebar w-64 fixed inset-y-0 left-0 transform transition-transform duration-300 ease-in-out flex flex-col flex-shrink-0 text-white shadow-2xl z-50">
            <div class="p-8 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/uniben-logo.png') }}" class="w-10 h-10 bg-white rounded-lg p-1 shadow-lg" alt="Logo">
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight">UBAA <span class="text-[var(--secondary)]">ADMIN</span></h1>
                        <p class="text-[10px] uppercase tracking-widest text-purple-300 font-bold opacity-70">Lagos Branch</p>
                    </div>
                </div>
                <button id="sidebarClose" class="text-white hover:text-[var(--secondary)] text-xl focus:outline-none transition-transform hover:rotate-90 duration-200" aria-label="Close sidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="px-6 mb-6">
                <div class="bg-black bg-opacity-20 rounded-2xl p-4 flex items-center gap-3 border border-white border-opacity-10">
                    <div class="w-10 h-10 rounded-full bg-[var(--secondary)] flex items-center justify-center text-purple-900 font-bold shadow-inner">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-bold truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-purple-300 uppercase font-bold">{{ auth()->user()->role }}</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-4">
                <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Dashboard</span>
                </a>
                
                @if(in_array(auth()->user()->role, ['chairman', 'secretary', 'admin']))
                <a href="{{ route('admin.users') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fas fa-user-friends w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Members</span>
                </a>
                <a href="{{ route('admin.executives') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.executives*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Executives</span>
                </a>
                @endif
                
                @if(in_array(auth()->user()->role, ['chairman', 'pro', 'admin']))
                <a href="{{ route('admin.news') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.news*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">News & Press</span>
                </a>
                @endif
                
                @if(in_array(auth()->user()->role, ['chairman', 'secretary', 'pro', 'admin']))
                <a href="{{ route('admin.events') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.events*') && !request()->routeIs('admin.events.reservations') ? 'active' : '' }}">
                    <i class="fas fa-calendar-star w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Events Hub</span>
                </a>
                <a href="{{ route('admin.reservations') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.reservations') || request()->routeIs('admin.events.reservations') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Reservations</span>
                </a>
                <a href="{{ route('admin.products') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Alumni Shop</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="fas fa-box-check w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Shop Orders</span>
                </a>
                @endif
                
                @if(in_array(auth()->user()->role, ['chairman', 'secretary', 'admin']))
                <a href="{{ route('admin.jobs') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.jobs*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Job Board</span>
                </a>
                <a href="{{ route('admin.payments') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
                    <i class="fas fa-wallet w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Financials</span>
                </a>
                <a href="{{ route('admin.donations') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.donations*') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-heart w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Donation Causes</span>
                </a>
                <a href="{{ route('admin.cooperative') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.cooperative*') ? 'active' : '' }}">
                    <i class="fas fa-users-rectangle w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Cooperative Society</span>
                </a>
                <a href="{{ route('admin.broadcasts') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.broadcasts*') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Email Broadcasts</span>
                </a>
                <a href="{{ route('admin.gallery') }}" class="nav-link flex items-center px-4 py-3 {{ request()->routeIs('admin.gallery*') ? 'active' : '' }}">
                    <i class="fas fa-images w-6 opacity-80"></i>
                    <span class="font-semibold text-sm">Visual Gallery</span>
                </a>
                @endif
            </nav>

            <div class="p-6">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-500 bg-opacity-20 hover:bg-opacity-30 text-red-100 py-3 rounded-xl border border-red-500 border-opacity-20 transition-all font-bold text-sm">
                        <i class="fas fa-power-off text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div id="mainContent" class="flex-1 flex flex-col overflow-hidden bg-[var(--bg-body)] transition-all duration-300">
            <!-- Header -->
            <header class="bg-white h-20 flex items-center justify-between px-4 md:px-8 border-b border-gray-200">
                <div class="flex items-center gap-4">
                    <button id="sidebarToggle" class="text-[var(--primary)] text-2xl focus:outline-none hover:scale-105 active:scale-95 transition-all" aria-label="Toggle menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-lg md:text-xl font-bold text-gray-800">@yield('title', 'Admin Overview')</h2>
                </div>
                
                <div class="flex items-center gap-4 md:gap-6">
                    <div class="hidden lg:flex items-center gap-2 text-sm text-gray-500 font-medium">
                        <i class="fas fa-clock text-[var(--primary)] opacity-50"></i>
                        <span>{{ now()->format('l, jS M Y') }}</span>
                    </div>
                    <div class="hidden lg:block h-8 w-[1px] bg-gray-200"></div>
                    <a href="{{ route('home') }}" target="_blank" class="text-sm font-bold text-[var(--primary)] hover:text-[var(--primary-dark)] flex items-center gap-2 transition-all">
                        <span>Visit Site</span>
                        <i class="fas fa-external-link-alt text-[10px]"></i>
                    </a>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8 custom-scrollbar">
                @if(session('success'))
                    <div class="mb-8 flex items-center gap-4 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-sm animate-fade-in">
                        <i class="fas fa-check-circle text-xl"></i>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-8 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm">
                        <div class="flex items-center gap-4 mb-2">
                            <i class="fas fa-exclamation-triangle text-xl"></i>
                            <p class="font-bold">Please correct the following errors:</p>
                        </div>
                        <ul class="list-disc list-inside text-sm font-medium ml-9">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
@yield('extra_js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('adminSidebar');
        const mainContent = document.getElementById('mainContent');
        const backdrop = document.getElementById('sidebarBackdrop');
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');

        function toggleSidebar() {
            const isMobile = window.innerWidth < 768;
            if (isMobile) {
                const isOpen = sidebar.classList.contains('open');
                if (isOpen) {
                    sidebar.classList.remove('open');
                    backdrop.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    sidebar.classList.add('open');
                    backdrop.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                }
            } else {
                const isCollapsed = sidebar.classList.contains('collapsed');
                if (isCollapsed) {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                } else {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                }
            }
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }
        if (backdrop) {
            backdrop.addEventListener('click', function() {
                sidebar.classList.remove('open');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        }
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                const isMobile = window.innerWidth < 768;
                if (isMobile) {
                    sidebar.classList.remove('open');
                    backdrop.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                }
            });
        }
    });
</script>
</body>
</html>
