<nav class="bottom-nav lg:hidden">
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>
        <span>HOME</span>
    </a>
    <a href="{{ route('directory') }}" class="nav-item {{ request()->routeIs('directory') ? 'active' : '' }}">
        <i class="fa-solid fa-user-group"></i>
        <span>DIRECTORY</span>
    </a>
    <a href="{{ route('shop') }}" class="nav-item {{ request()->routeIs('shop') || request()->is('shop/*') ? 'active' : '' }}">
        <i class="fa-solid fa-store"></i>
        <span>SHOP</span>
    </a>
    <a href="{{ route('payments') }}" class="nav-item {{ request()->routeIs('payments') || request()->routeIs('donate') || request()->is('transactions*') ? 'active' : '' }}">
        <i class="fa-solid fa-wallet"></i>
        <span>PAYMENTS</span>
    </a>
    <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') || request()->routeIs('profile.edit') ? 'active' : '' }}">
        <i class="fa-regular fa-user"></i>
        <span>PROFILE</span>
    </a>
</nav>
