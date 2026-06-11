@extends('admin.layouts.app')

@section('title', 'Membership Management')

@section('content')
{{-- Birthday Celebrants Section --}}
@if($todayCelebrants->count() > 0 || $weekCelebrants->count() > 0)
<div class="mb-8">
    {{-- Today's Birthday Card --}}
    @if($todayCelebrants->count() > 0)
    <div class="bg-gradient-to-r from-purple-50 via-pink-50 to-yellow-50 rounded-[24px] md:rounded-[32px] border border-purple-100 p-6 md:p-8 mb-6 relative overflow-hidden">
        <div class="absolute top-4 right-8 text-6xl opacity-10">🎂</div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-2xl shadow-lg shadow-purple-200">
                    🎉
                </div>
                <div>
                    <h3 class="text-lg md:text-xl font-extrabold text-gray-800">Today's Birthday Celebrant(s)</h3>
                    <p class="text-sm text-gray-500 font-medium">{{ now()->format('l, jS F Y') }}</p>
                </div>
            </div>
            @if($todayCelebrants->count() > 0)
            <form action="{{ route('admin.users.birthday-emails-all') }}" method="POST" class="inline-block w-full sm:w-auto">
                @csrf
                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-500 text-white px-6 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-all shadow-lg shadow-purple-200 flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane text-xs"></i> Send All Birthday Emails
                </button>
            </form>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($todayCelebrants as $celebrant)
            <div class="bg-white bg-opacity-80 backdrop-blur-sm rounded-2xl p-4 md:p-5 flex items-center gap-3 md:gap-4 border border-purple-100 shadow-sm hover:shadow-md transition-all">
                @if($celebrant->avatar_url)
                    <img class="h-12 w-12 md:h-14 md:w-14 rounded-xl object-cover shadow-sm border-2 border-white" src="{{ asset($celebrant->avatar_url) }}" alt="">
                @else
                    <div class="h-12 w-12 md:h-14 md:w-14 rounded-xl bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-black text-lg md:text-xl shadow-sm">
                        {{ substr($celebrant->name, 0, 1) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="font-extrabold text-gray-800 text-sm truncate">{{ $celebrant->name }}</p>
                    <p class="text-xs text-gray-500 font-medium truncate">{{ $celebrant->email }}</p>
                    @if($celebrant->date_of_birth)
                    <p class="text-xs text-purple-500 font-bold mt-1">
                        🎂 {{ \Carbon\Carbon::parse($celebrant->date_of_birth)->format('jS F') }}
                    </p>
                    @endif
                </div>
                <form action="{{ route('admin.users.birthday-email', $celebrant) }}" method="POST" class="flex-shrink-0">
                    @csrf
                    <button type="submit" class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 hover:bg-purple-200 flex items-center justify-center transition-all" title="Send Birthday Email">
                        <i class="fas fa-envelope text-xs"></i>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- This Week's Birthdays --}}
    @if($weekCelebrants->count() > 0 && $todayCelebrants->count() == 0)
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-[24px] md:rounded-[32px] border border-blue-100 p-5 md:p-6 mb-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 text-lg">📅</div>
            <div>
                <h4 class="font-extrabold text-gray-800">This Week's Birthdays</h4>
                <p class="text-xs text-gray-500 font-medium">{{ now()->startOfWeek()->format('M d') }} - {{ now()->endOfWeek()->format('M d, Y') }}</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            @foreach($weekCelebrants as $celebrant)
            <div class="bg-white rounded-xl px-4 py-3 flex items-center gap-3 border border-blue-50 shadow-sm">
                @if($celebrant->avatar_url)
                    <img class="h-8 w-8 rounded-lg object-cover" src="{{ asset($celebrant->avatar_url) }}" alt="">
                @else
                    <div class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                        {{ substr($celebrant->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <p class="font-bold text-gray-700 text-xs">{{ $celebrant->name }}</p>
                    <p class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($celebrant->date_of_birth)->format('M d') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endif

<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h3 class="text-2xl font-extrabold text-gray-800">Alumni Directory</h3>
        <p class="text-gray-500 font-medium text-sm">Review and manage the Lagos Branch membership base.</p>
    </div>
    <div class="flex flex-wrap gap-2 md:gap-3 w-full sm:w-auto">
        <a href="{{ route('admin.broadcasts.create') }}" class="flex-1 sm:flex-initial bg-[var(--primary)] text-white font-bold px-5 py-3 rounded-xl border-none shadow-sm hover:brightness-110 transition-all flex items-center justify-center gap-2 text-sm">
            <i class="fas fa-paper-plane text-xs"></i> Broadcast Email
        </a>
        <button class="flex-1 sm:flex-initial bg-white text-gray-700 font-bold px-5 py-3 rounded-xl border border-gray-200 shadow-sm hover:bg-gray-50 transition-all flex items-center justify-center gap-2 text-sm">
            <i class="fas fa-file-export text-xs"></i> Export CSV
        </button>
    </div>
</div>

<div class="bg-white rounded-[20px] md:rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50 bg-opacity-50">
                    <th class="px-4 md:px-8 py-4 md:py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Member Name</th>
                    <th class="px-4 md:px-8 py-4 md:py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Email Address</th>
                    <th class="px-4 md:px-8 py-4 md:py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Matric Number</th>
                    <th class="px-4 md:px-8 py-4 md:py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Phone Number</th>
                    <th class="px-4 md:px-8 py-4 md:py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Birthday</th>
                    <th class="px-4 md:px-8 py-4 md:py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Joined On</th>
                    <th class="px-4 md:px-8 py-4 md:py-5 text-right text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                <tr class="hover:bg-purple-50 hover:bg-opacity-30 transition-colors group">
                    <td class="px-4 md:px-8 py-4 md:py-5 whitespace-nowrap">
                        <div class="flex items-center gap-3 md:gap-4">
                            @if($user->avatar_url)
                                <img class="h-9 w-9 md:h-10 md:w-10 rounded-xl object-cover shadow-sm border-2 border-white" src="{{ asset($user->avatar_url) }}" alt="">
                            @else
                                <div class="h-9 w-9 md:h-10 md:w-10 rounded-xl bg-purple-100 flex items-center justify-center text-[var(--primary)] font-black shadow-sm border-2 border-white text-xs md:text-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="text-sm font-extrabold text-gray-800">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td class="px-4 md:px-8 py-4 md:py-5 whitespace-nowrap text-sm text-gray-600 font-medium">
                        {{ $user->email }}
                    </td>
                    <td class="px-4 md:px-8 py-4 md:py-5 whitespace-nowrap text-sm text-gray-500 font-bold tracking-tight">
                        {{ $user->matric_number ?? '---' }}
                    </td>
                    <td class="px-4 md:px-8 py-4 md:py-5 whitespace-nowrap text-sm text-gray-600 font-semibold">
                        {{ $user->phone ?? '---' }}
                    </td>
                    <td class="px-4 md:px-8 py-4 md:py-5 whitespace-nowrap text-sm">
                        @if($user->date_of_birth)
                            @php
                                $isTodayBirthday = \Carbon\Carbon::parse($user->date_of_birth)->format('m-d') === now()->format('m-d');
                            @endphp
                            <span class="{{ $isTodayBirthday ? 'bg-pink-100 text-pink-700 px-3 py-1 rounded-full font-bold' : 'text-gray-500 font-medium' }}">
                                {{ $isTodayBirthday ? '🎂 ' : '' }}{{ \Carbon\Carbon::parse($user->date_of_birth)->format('M d') }}
                            </span>
                        @else
                            <span class="text-gray-400">---</span>
                        @endif
                    </td>
                    <td class="px-4 md:px-8 py-4 md:py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-4 md:px-8 py-4 md:py-5 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 text-[var(--primary)] hover:text-[var(--primary-dark)] bg-purple-50 px-3 md:px-4 py-2 rounded-xl transition-all font-bold">
                            <i class="fas fa-user-edit text-xs"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-5 md:p-8 border-t border-gray-50 bg-gray-50 bg-opacity-30">
        {{ $users->links() }}
    </div>
</div>
@endsection
