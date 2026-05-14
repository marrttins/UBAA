@extends('admin.layouts.app')

@section('title', 'Events Hub')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-extrabold text-gray-800">Event Coordination</h3>
        <p class="text-gray-500 font-medium text-sm">Schedule and manage upcoming branch activities.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.events.create') }}" class="bg-[var(--primary)] text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-purple-100 hover:bg-[var(--primary-dark)] transition-all flex items-center gap-2">
            <i class="fas fa-plus-circle text-xs"></i> Create New Event
        </a>
    </div>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50 bg-opacity-50">
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Event Information</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Date & Time</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Location</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Access Fee</th>
                    <th class="px-8 py-5 text-right text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Operations</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($events as $event)
                <tr class="hover:bg-purple-50 hover:bg-opacity-30 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-2xl bg-purple-100 flex items-center justify-center text-[var(--primary)] shadow-sm border-2 border-white">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <div class="text-sm font-extrabold text-gray-800">{{ $event->title }}</div>
                                <div class="text-[11px] text-gray-400 font-bold uppercase tracking-wider line-clamp-1 max-w-[200px]">{{ $event->description ?? 'No Description' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-700">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</div>
                        <div class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-2 text-sm text-gray-600 font-medium">
                            <i class="fas fa-map-marker-alt text-[var(--primary)] opacity-40"></i>
                            {{ $event->location_name ?? 'TBD' }} ({{ $event->location_type ?? 'Physical' }})
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-extrabold rounded-full bg-gold-50 text-[var(--secondary)] border border-yellow-100 uppercase tracking-widest" style="background-color: rgba(212, 175, 55, 0.05);">
                            {{ $event->fee && $event->fee > 0 ? '₦' . number_format($event->fee, 0) : 'Free' }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.events.reservations', $event) }}" class="inline-flex items-center gap-2 text-green-600 hover:text-green-800 bg-green-50 px-3 py-1.5 rounded-lg transition-all font-bold">
                                <i class="fas fa-users text-xs"></i> RSVP
                            </a>
                            <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex items-center gap-2 text-[var(--primary)] hover:text-[var(--primary-dark)] bg-purple-50 px-3 py-1.5 rounded-lg transition-all font-bold">
                                <i class="fas fa-edit text-xs"></i> Edit
                            </a>
                            <form action="{{ route('admin.events.delete', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-2 text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition-all font-bold">
                                    <i class="fas fa-trash text-xs"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-8 border-t border-gray-50 bg-gray-50 bg-opacity-30">
        {{ $events->links() }}
    </div>
</div>
@endsection
