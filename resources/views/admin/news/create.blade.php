@extends('admin.layouts.app')

@section('title', 'Create News Article')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.news') }}" class="text-[var(--primary)] font-bold text-sm flex items-center gap-2 hover:translate-x-[-5px] transition-transform">
            <i class="fas fa-arrow-left text-xs"></i> Back to Communication Center
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 bg-gray-50 bg-opacity-30">
            <h3 class="text-2xl font-extrabold text-gray-800">New Article</h3>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-[2px]">Compose a new story for the alumni community.</p>
        </div>

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Article Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. Annual Alumni Homecoming 2026" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Category</label>
                    <select name="category" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                        <option value="General">General News</option>
                        <option value="UNIBEN News">UNIBEN News</option>
                        <option value="Admission Update">Admission Update</option>
                        <option value="Events">Event Updates</option>
                        <option value="Achievements">Alumni Achievements</option>
                        <option value="Notices">Official Notices</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Author Name</label>
                    <input type="text" name="author" value="{{ old('author', auth()->user()->name) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Short Summary</label>
                    <input type="text" name="summary" value="{{ old('summary') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Brief intro (shows on the list page)">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Upload Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Or External Image URL</label>
                    <input type="text" name="image_url" value="{{ old('image_url') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="https://example.com/image.jpg">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Article Content</label>
                    <textarea name="content" rows="12" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Tell the story..." required>{{ old('content') }}</textarea>
                </div>
            </div>
            
            <div class="flex items-center gap-4 border-t border-gray-50 pt-10">
                <button type="submit" class="bg-[var(--primary)] text-white py-4 px-12 rounded-2xl font-bold hover:bg-[var(--primary-dark)] transition-all shadow-lg shadow-purple-100 flex items-center gap-3">
                    <i class="fas fa-paper-plane text-xs"></i> Publish Article
                </button>
                <a href="{{ route('admin.news') }}" class="text-gray-400 font-bold hover:text-gray-600 transition-colors px-6">Discard</a>
            </div>
        </form>
    </div>
</div>
@endsection
