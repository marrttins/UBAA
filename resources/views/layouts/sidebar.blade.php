<aside class="sidebar">
    <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('directory') }}" class="nav-item {{ request()->routeIs('directory') ? 'active' : '' }}">
        <i class="fa-solid fa-user-group"></i>
        <span>Directory</span>
    </a>
    <a href="{{ route('events') }}" class="nav-item {{ request()->routeIs('events') || request()->is('events-detail*') ? 'active' : '' }}">
        <i class="fa-solid fa-calendar-check"></i>
        <span>Events</span>
    </a>
    <a href="{{ route('shop') }}" class="nav-item {{ request()->routeIs('shop') || request()->is('shop/*') ? 'active' : '' }}">
        <i class="fa-solid fa-store"></i>
        <span>Shop</span>
    </a>
    <a href="{{ route('jobs') }}" class="nav-item {{ request()->routeIs('jobs') || request()->routeIs('jobs.create') ? 'active' : '' }}">
        <i class="fa-solid fa-briefcase"></i>
        <span>Jobs</span>
    </a>
    <a href="{{ route('payments') }}" class="nav-item {{ request()->routeIs('payments') || request()->is('transactions*') ? 'active' : '' }}">
        <i class="fa-solid fa-wallet"></i>
        <span>Payments</span>
    </a>
    <a href="{{ route('donate') }}" class="nav-item {{ request()->routeIs('donate') ? 'active' : '' }}">
        <i class="fa-solid fa-heart"></i>
        <span>Donate</span>
    </a>
    <a href="{{ route('notifications') }}" class="nav-item {{ request()->routeIs('notifications') ? 'active' : '' }}">
        <i class="fa-solid fa-bell"></i>
        <span>Inbox</span>
    </a>
    <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') || request()->routeIs('profile.edit') ? 'active' : '' }}">
        <i class="fa-regular fa-user"></i>
        <span>Profile</span>
    </a>
    <div class="mt-auto pt-10">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item w-full text-red-500 hover:bg-red-50 transition-colors">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
