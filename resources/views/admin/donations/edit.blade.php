@extends('admin.layouts.app')

@section('title', 'Edit Donation Project')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.donations') }}" class="text-[var(--primary)] font-bold text-sm flex items-center gap-2 hover:translate-x-[-5px] transition-transform">
            <i class="fas fa-arrow-left text-xs"></i> Back to Projects
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 bg-gray-50 bg-opacity-30">
            <h3 class="text-2xl font-extrabold text-gray-800">Edit Campaign</h3>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-[2px]">Update details for {{ $project->title }}</p>
        </div>

        <form action="{{ route('admin.donations.update', $project) }}" method="POST" class="p-10">
            @csrf
            <div class="space-y-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Project Title</label>
                    <input type="text" name="title" value="{{ old('title', $project->title) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. Scholarship Fund 2024" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Goal Amount (₦)</label>
                        <input type="number" name="goal_amount" value="{{ old('goal_amount', $project->goal_amount) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. 5000000" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Icon (FontAwesome Class)</label>
                        <select name="icon" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                            @foreach([
                                'fa-hand-holding-heart' => 'Heart (Donation)',
                                'fa-graduation-cap' => 'Cap (Scholarship)',
                                'fa-microscope' => 'Microscope (Labs)',
                                'fa-building-columns' => 'Building (Infrastructure)',
                                'fa-laptop-code' => 'Laptop (Technology)',
                                'fa-book' => 'Book (Library)'
                            ] as $val => $label)
                                <option value="{{ $val }}" {{ $project->icon == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Project Description</label>
                    <textarea name="description" rows="5" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Describe the purpose and impact of this donation..." required>{{ old('description', $project->description) }}</textarea>
                </div>

                <div class="bg-purple-50 p-6 rounded-2xl border border-purple-100 flex items-center gap-4">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $project->is_active ? 'checked' : '' }} class="w-5 h-5 rounded-lg text-primary focus:ring-primary border-gray-200">
                    <label for="is_active" class="text-sm font-bold text-primary leading-relaxed cursor-pointer">Activate this campaign.</label>
                </div>
            </div>

            <div class="flex items-center gap-4 border-t border-gray-50 mt-10 pt-10">
                <button type="submit" class="bg-primary text-white py-4 px-12 rounded-2xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-purple-100 flex items-center gap-3">
                    <i class="fas fa-save text-xs"></i> Update Project
                </button>
                <a href="{{ route('admin.donations') }}" class="text-gray-400 font-bold hover:text-gray-600 transition-colors px-6">Discard</a>
            </div>
        </form>
    </div>
</div>
@endsection
