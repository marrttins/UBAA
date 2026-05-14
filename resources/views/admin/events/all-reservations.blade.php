@extends('admin.layouts.app')

@section('title', 'Event Reservations Overview')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-extrabold text-gray-800">Event Reservations</h3>
        <p class="text-gray-500 font-medium text-sm">Select an event below to view all attendees who have booked a seat.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($events as $event)
    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
        <div class="h-32 bg-gray-100 relative">
            @if($event->image_url)
                <img src="{{ str_starts_with($event->image_url, 'http') ? $event->image_url : asset($event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300">
                    <i class="fas fa-image text-3xl"></i>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute bottom-4 left-4 text-white">
                <span class="text-[10px] font-bold uppercase tracking-widest text-purple-200">{{ $event->category ?? 'Event' }}</span>
                <h4 class="font-extrabold truncate w-48">{{ $event->title }}</h4>
            </div>
        </div>
        
        <div class="p-6 flex-1 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1"><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500"><i class="fas fa-map-marker-alt mr-1"></i> {{ Str::limit($event->location_name, 25) }}</p>
                    </div>
                    <div class="bg-purple-50 text-[var(--primary)] px-3 py-1 rounded-full text-xs font-bold text-center">
                        {{ $event->reservations_count }}<br><span class="text-[9px] uppercase tracking-wider">Bookings</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-50">
                <a href="{{ route('admin.events.reservations', $event->id) }}" class="block w-full text-center bg-green-50 text-green-700 hover:bg-green-600 hover:text-white px-4 py-2.5 rounded-xl font-bold text-sm transition-colors shadow-sm">
                    Check All Reservations
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white p-12 text-center rounded-[24px] border border-gray-100">
        <i class="fas fa-calendar-times text-gray-300 text-4xl mb-3"></i>
        <p class="text-gray-500 font-medium">No events found.</p>
    </div>
    @endforelse
</div>

@if($events->hasPages())
<div class="mt-8">
    {{ $events->links() }}
</div>
@endif
@endsection
