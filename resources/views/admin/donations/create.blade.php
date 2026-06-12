@extends('admin.layouts.app')

@section('title', 'New Donation Project')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.donations') }}" class="text-[var(--primary)] font-bold text-sm flex items-center gap-2 hover:translate-x-[-5px] transition-transform">
            <i class="fas fa-arrow-left text-xs"></i> Back to Projects
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 bg-gray-50 bg-opacity-30">
            <h3 class="text-2xl font-extrabold text-gray-800">New Campaign</h3>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-[2px]">Launch a new fundraising cause for the branch.</p>
        </div>

        <form action="{{ route('admin.donations.store') }}" method="POST" class="p-10">
            @csrf
            <div class="space-y-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Project Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. Scholarship Fund 2024" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Goal Amount (₦)</label>
                        <input type="number" name="goal_amount" value="{{ old('goal_amount') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. 5000000" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Icon (FontAwesome Class)</label>
                        <select name="icon" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                            <option value="fa-hand-holding-heart">Heart (Donation)</option>
                            <option value="fa-graduation-cap">Cap (Scholarship)</option>
                            <option value="fa-microscope">Microscope (Labs)</option>
                            <option value="fa-building-columns">Building (Infrastructure)</option>
                            <option value="fa-laptop-code">Laptop (Technology)</option>
                            <option value="fa-book">Book (Library)</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Project Description</label>
                    <textarea name="description" rows="5" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Describe the purpose and impact of this donation..." required>{{ old('description') }}</textarea>
                </div>

                <div class="bg-purple-50 p-6 rounded-2xl border border-purple-100 flex items-center gap-4">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-5 h-5 rounded-lg text-primary focus:ring-primary border-gray-200">
                    <label for="is_active" class="text-sm font-bold text-primary leading-relaxed cursor-pointer">Activate this campaign immediately.</label>
                </div>
            </div>

            <div class="flex items-center gap-4 border-t border-gray-50 mt-10 pt-10">
                <button type="submit" class="bg-[var(--primary)] text-white py-4 px-12 rounded-2xl font-bold hover:bg-[var(--primary-dark)] transition-all shadow-lg shadow-purple-50 flex items-center gap-3">
                    <i class="fas fa-rocket text-xs"></i> Launch Project
                </button>
                <a href="{{ route('admin.donations') }}" class="border border-gray-200 text-gray-500 font-bold py-4 px-8 rounded-2xl hover:bg-gray-50 hover:text-gray-700 transition-all">Discard</a>
            </div>
        </form>
    </div>
</div>
@endsection
