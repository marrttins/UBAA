@extends('admin.layouts.app')

@section('title', 'Event Reservations')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <a href="{{ route('admin.events') }}" class="text-[var(--primary)] font-bold text-sm flex items-center gap-2 hover:translate-x-[-5px] transition-transform mb-4">
            <i class="fas fa-arrow-left text-xs"></i> Back to Events
        </a>
        <h3 class="text-2xl font-extrabold text-gray-800">Reservations: {{ Str::limit($event->title, 40) }}</h3>
        <p class="text-gray-500 font-medium text-sm">View all attendees who have booked a seat for this event.</p>
    </div>
    <div class="flex gap-3">
        <div class="bg-green-50 text-green-700 px-6 py-3 rounded-xl border border-green-100 font-bold flex items-center gap-2 shadow-sm">
            <i class="fas fa-ticket-alt"></i> {{ $reservations->total() }} Reserved Seats
        </div>
    </div>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50 bg-opacity-50">
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Attendee Name</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Contact Info</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Payment Status</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Date Booked</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($reservations as $rsvp)
                <tr class="hover:bg-purple-50 hover:bg-opacity-30 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-[var(--primary)] font-bold uppercase shadow-sm border-2 border-white">
                                {{ substr($rsvp->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-extrabold text-gray-800">{{ $rsvp->name }}</div>
                                @if($rsvp->user_id)
                                    <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-bold">Registered Member</span>
                                @else
                                    <span class="text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-bold">Guest</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-700"><i class="fas fa-envelope text-gray-400 mr-2 text-[10px]"></i>{{ $rsvp->email }}</div>
                        <div class="text-sm text-gray-500"><i class="fas fa-phone text-gray-400 mr-2 text-[10px]"></i>{{ $rsvp->phone ?? 'N/A' }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($rsvp->amount > 0)
                            <div class="text-sm font-extrabold text-gray-800 mb-1">₦{{ number_format($rsvp->amount, 0) }}</div>
                            <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-extrabold rounded-full bg-green-50 text-green-600 uppercase tracking-widest">
                                {{ $rsvp->payment_method ?? 'Paid' }}
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-extrabold rounded-full bg-gray-100 text-gray-600 uppercase tracking-widest">
                                Free Access
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                        {{ $rsvp->created_at->format('M d, Y') }} <br>
                        <span class="text-[11px] text-gray-400">{{ $rsvp->created_at->format('h:i A') }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-12 text-center text-gray-400 font-medium">
                        No seat reservations found for this event yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reservations->hasPages())
    <div class="p-8 border-t border-gray-50 bg-gray-50 bg-opacity-30">
        {{ $reservations->links() }}
    </div>
    @endif
</div>
@endsection
