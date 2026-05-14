@extends('admin.layouts.app')

@section('title', 'Create Event')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.events') }}" class="text-[var(--primary)] font-bold text-sm flex items-center gap-2 hover:translate-x-[-5px] transition-transform">
            <i class="fas fa-arrow-left text-xs"></i> Back to Events Hub
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 bg-gray-50 bg-opacity-30">
            <h3 class="text-2xl font-extrabold text-gray-800">New Event</h3>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-[2px]">Schedule a new branch activity.</p>
        </div>

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Event Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. End of Year Dinner" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Event Date & Time</label>
                    <input type="datetime-local" name="event_date" value="{{ old('event_date') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Category</label>
                    <select name="category" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                        <option value="Meeting">Meeting</option>
                        <option value="Dinner/Party">Dinner/Party</option>
                        <option value="Seminar">Seminar / Workshop</option>
                        <option value="Reunion">Reunion</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Location Type</label>
                    <select name="location_type" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                        <option value="Physical">Physical / In-person</option>
                        <option value="Virtual">Virtual / Online</option>
                        <option value="Hybrid">Hybrid</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Location Name/Link</label>
                    <input type="text" name="location_name" value="{{ old('location_name') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. Lagos Sheraton Hotel or Zoom Link">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Access Fee (₦)</label>
                    <input type="number" name="fee" value="{{ old('fee', 0) }}" min="0" step="100" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                    <p class="text-xs text-gray-400 mt-1 px-2">Leave as 0 for Free Events</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Upload Event Banner</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Or External Image URL</label>
                    <input type="text" name="image_url" value="{{ old('image_url') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="https://example.com/banner.jpg">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Event Description</label>
                    <textarea name="description" rows="8" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Event details, agenda, and expectations..." required>{{ old('description') }}</textarea>
                </div>
            </div>
            
            <div class="flex items-center gap-4 border-t border-gray-50 pt-10">
                <button type="submit" class="bg-[var(--primary)] text-white py-4 px-12 rounded-2xl font-bold hover:bg-[var(--primary-dark)] transition-all shadow-lg shadow-purple-100 flex items-center gap-3">
                    <i class="fas fa-calendar-check text-xs"></i> Create Event
                </button>
                <a href="{{ route('admin.events') }}" class="text-gray-400 font-bold hover:text-gray-600 transition-colors px-6">Discard</a>
            </div>
        </form>
    </div>
</div>
@endsection
