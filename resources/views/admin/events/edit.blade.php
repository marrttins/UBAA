@extends('admin.layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.events') }}" class="text-[var(--primary)] font-bold text-sm flex items-center gap-2 hover:translate-x-[-5px] transition-transform">
            <i class="fas fa-arrow-left text-xs"></i> Back to Events Hub
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 bg-gray-50 bg-opacity-30">
            <h3 class="text-2xl font-extrabold text-gray-800">Edit Event</h3>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-[2px]">Modifying: {{ $event->title }}</p>
        </div>

        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Event Title</label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Event Date & Time</label>
                    <input type="datetime-local" name="event_date" value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i')) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Category</label>
                    <select name="category" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                        <option value="Meeting" {{ $event->category == 'Meeting' ? 'selected' : '' }}>Meeting</option>
                        <option value="Dinner/Party" {{ $event->category == 'Dinner/Party' ? 'selected' : '' }}>Dinner/Party</option>
                        <option value="Seminar" {{ $event->category == 'Seminar' ? 'selected' : '' }}>Seminar / Workshop</option>
                        <option value="Reunion" {{ $event->category == 'Reunion' ? 'selected' : '' }}>Reunion</option>
                        <option value="Other" {{ $event->category == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Location Type</label>
                    <select name="location_type" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                        <option value="Physical" {{ $event->location_type == 'Physical' ? 'selected' : '' }}>Physical / In-person</option>
                        <option value="Virtual" {{ $event->location_type == 'Virtual' ? 'selected' : '' }}>Virtual / Online</option>
                        <option value="Hybrid" {{ $event->location_type == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Location Name/Link</label>
                    <input type="text" name="location_name" value="{{ old('location_name', $event->location_name) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Access Fee (₦)</label>
                    <input type="number" name="fee" value="{{ old('fee', $event->fee) }}" min="0" step="100" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Upload New Banner (Overrides)</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Or External Image URL</label>
                    <input type="text" name="image_url" value="{{ old('image_url', $event->image_url) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Event Description</label>
                    <textarea name="description" rows="8" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" required>{{ old('description', $event->description) }}</textarea>
                </div>
            </div>
            
            <div class="flex items-center gap-4 border-t border-gray-50 pt-10">
                <button type="submit" class="bg-[var(--primary)] text-white py-4 px-12 rounded-2xl font-bold hover:bg-[var(--primary-dark)] transition-all shadow-lg shadow-purple-100 flex items-center gap-3">
                    <i class="fas fa-save text-xs"></i> Update Event
                </button>
                <a href="{{ route('admin.events') }}" class="text-gray-400 font-bold hover:text-gray-600 transition-colors px-6">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
