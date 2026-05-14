@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
    <!-- Stat Card: Users -->
    <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-purple-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center text-[var(--primary)] mb-6 shadow-sm">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-widest mb-1">Total Members</p>
            <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['users'] }}</h3>
        </div>
    </div>
    
    <!-- Stat Card: Jobs -->
    <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-gold-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110" style="background-color: rgba(212, 175, 55, 0.05);"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center text-[var(--secondary)] mb-6 shadow-sm">
                <i class="fas fa-briefcase text-2xl"></i>
            </div>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-widest mb-1">Job Postings</p>
            <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['jobs'] }}</h3>
        </div>
    </div>
    
    <!-- Stat Card: Events -->
    <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 shadow-sm">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-widest mb-1">Active Events</p>
            <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['events'] }}</h3>
        </div>
    </div>
    
    <!-- Stat Card: News -->
    <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-pink-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center text-pink-600 mb-6 shadow-sm">
                <i class="fas fa-newspaper text-2xl"></i>
            </div>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-widest mb-1">News Articles</p>
            <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['news'] }}</h3>
        </div>
    </div>
</div>

<div class="bg-white rounded-[32px] p-10 border border-gray-100 shadow-sm relative overflow-hidden">
    <div class="absolute top-0 right-0 p-12 opacity-5 pointer-events-none">
        <i class="fas fa-university text-[200px] text-[var(--primary)]"></i>
    </div>
    <div class="relative z-10 max-w-2xl">
        <span class="inline-block bg-purple-50 text-[var(--primary)] text-[10px] font-extrabold uppercase tracking-widest px-4 py-2 rounded-full mb-6 border border-purple-100">Quick Access Portal</span>
        <h3 class="text-4xl font-extrabold text-gray-900 mb-6 leading-tight">Welcome to the Command Center, <span class="text-[var(--primary)]">{{ auth()->user()->first_name ?? auth()->user()->name }}</span>.</h3>
        <p class="text-gray-500 text-lg leading-relaxed mb-8 font-medium">
            Manage your members, broadcast news, and coordinate alumni events with ease. Your current privileges as <span class="text-[var(--primary)] font-bold capitalize">{{ auth()->user()->role }}</span> give you full control over the respective modules in the sidebar.
        </p>
        <div class="flex gap-4">
            <a href="{{ route('admin.users') }}" class="bg-[var(--primary)] text-white px-8 py-4 rounded-2xl font-bold hover:bg-[var(--primary-dark)] transition-all shadow-lg shadow-purple-200">Manage Members</a>
            <a href="{{ route('admin.news') }}" class="bg-white text-[var(--primary)] border-2 border-[var(--primary)] px-8 py-4 rounded-2xl font-bold hover:bg-purple-50 transition-all">Latest Updates</a>
        </div>
    </div>
</div>
@endsection
