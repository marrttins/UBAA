@extends('admin.layouts.app')

@section('title', 'Executive Management')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-extrabold text-gray-800">Branch Executives</h3>
        <p class="text-gray-500 font-medium text-sm">Manage administrative accounts and roles for the branch.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.executives.create') }}" class="bg-[var(--primary)] text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-purple-100 hover:bg-[var(--primary-dark)] transition-all flex items-center gap-2">
            <i class="fas fa-plus-circle text-xs"></i> Add New Executive
        </a>
    </div>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50 bg-opacity-50">
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Executive Details</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Email Address</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Administrative Role</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Created</th>
                    <th class="px-8 py-5 text-right text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Operations</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                <tr class="hover:bg-purple-50 hover:bg-opacity-30 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-4">
                            @if($user->avatar_url)
                                <img class="h-12 w-12 rounded-2xl object-cover shadow-sm border-2 border-white" src="{{ asset($user->avatar_url) }}" alt="">
                            @else
                                <div class="h-12 w-12 rounded-2xl bg-purple-100 flex items-center justify-center text-[var(--primary)] font-black shadow-sm border-2 border-white">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <div class="text-sm font-extrabold text-gray-800">{{ $user->name }}</div>
                                <div class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Executive Member</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-600 font-medium">
                        {{ $user->email }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @php
                            $roleNames = [
                                'admin' => 'Admin',
                                'chairman' => 'Chairman',
                                'vice_chairman' => 'Vice Chairman',
                                'secretary' => 'Secretary',
                                'legal' => 'Legal Adviser',
                                'welfare' => 'Welfare Sec.',
                                'pro' => 'PRO',
                                'pro_ii' => 'PRO II'
                            ];
                        @endphp
                        <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-extrabold rounded-full border 
                            @if($user->role == 'admin' || $user->role == 'chairman') bg-purple-50 text-[var(--primary)] border-purple-100
                            @elseif(in_array($user->role, ['secretary', 'pro'])) bg-yellow-50 text-[var(--secondary)] border-yellow-100
                            @else bg-green-50 text-green-600 border-green-100 @endif uppercase tracking-wider">
                            {{ $roleNames[$user->role] ?? $user->role }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 text-[var(--primary)] hover:text-[var(--primary-dark)] bg-purple-50 px-4 py-2 rounded-xl transition-all font-bold">
                            <i class="fas fa-edit text-xs"></i> Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-8 border-t border-gray-50 bg-gray-50 bg-opacity-30">
        {{ $users->links() }}
    </div>
</div>
@endsection
