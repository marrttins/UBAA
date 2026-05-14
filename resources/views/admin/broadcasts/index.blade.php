@extends('admin.layouts.app')

@section('title', 'Email Broadcasts')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-extrabold text-gray-800">Email Broadcasts</h3>
        <p class="text-gray-500 font-medium text-sm">Send email communications to all or selected members.</p>
    </div>
    <a href="{{ route('admin.broadcasts.create') }}" class="bg-[var(--primary)] text-white font-bold px-6 py-3 rounded-xl hover:brightness-110 transition-all shadow-lg shadow-purple-100 flex items-center gap-2">
        <i class="fas fa-plus text-xs"></i> New Broadcast
    </a>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-[var(--primary)]">
                <i class="fas fa-paper-plane text-lg"></i>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-800">{{ $broadcasts->total() }}</p>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Broadcasts</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                <i class="fas fa-envelope-open text-lg"></i>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-800">{{ $broadcasts->sum('total_sent') }}</p>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Emails Sent</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                <i class="fas fa-users text-lg"></i>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-800">{{ \App\Models\User::count() }}</p>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Members</p>
            </div>
        </div>
    </div>
</div>

{{-- Broadcasts Table --}}
<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50 bg-opacity-50">
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Subject</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Type</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Recipients</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Sent By</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Sent At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($broadcasts as $broadcast)
                <tr class="hover:bg-purple-50 hover:bg-opacity-30 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center text-[var(--primary)] flex-shrink-0">
                                <i class="fas fa-envelope text-sm"></i>
                            </div>
                            <div>
                                <p class="font-extrabold text-gray-800 text-sm">{{ $broadcast->subject }}</p>
                                <p class="text-xs text-gray-400 font-medium truncate max-w-xs">{{ Str::limit($broadcast->message, 60) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($broadcast->recipient_type === 'all')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">All Members</span>
                        @else
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Selected</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="text-sm font-extrabold text-gray-800">{{ $broadcast->total_sent }}</span>
                        <span class="text-xs text-gray-400 font-medium ml-1">emails</span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-600 font-medium">
                        {{ $broadcast->sender->name ?? 'System' }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                        {{ $broadcast->sent_at ? $broadcast->sent_at->format('M d, Y h:i A') : '---' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-16 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-300 text-3xl">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <p class="text-gray-400 font-bold">No broadcasts sent yet</p>
                            <a href="{{ route('admin.broadcasts.create') }}" class="text-[var(--primary)] font-bold text-sm hover:underline">Send your first broadcast →</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($broadcasts->hasPages())
    <div class="p-8 border-t border-gray-50 bg-gray-50 bg-opacity-30">
        {{ $broadcasts->links() }}
    </div>
    @endif
</div>
@endsection
