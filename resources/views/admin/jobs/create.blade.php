@extends('admin.layouts.app')

@section('title', 'Post New Vacancy')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.jobs') }}" class="text-[var(--primary)] font-bold text-sm flex items-center gap-2 hover:translate-x-[-5px] transition-transform">
            <i class="fas fa-arrow-left text-xs"></i> Back to Job Board
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm font-bold border border-red-100">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 bg-gray-50 bg-opacity-30">
            <h3 class="text-2xl font-extrabold text-gray-800">New Vacancy</h3>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-[2px]">Post a new job opening for the alumni community. As an Admin, this will be auto-approved.</p>
        </div>

        <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Job Title / Role</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. Senior Project Manager" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Company Name</label>
                    <input type="text" name="company" value="{{ old('company') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Organization Name" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Work Environment</label>
                    <select name="environment" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                        <option value="Office" {{ old('environment') == 'Office' ? 'selected' : '' }}>Office Based</option>
                        <option value="Remote" {{ old('environment') == 'Remote' ? 'selected' : '' }}>Remote</option>
                        <option value="Hybrid" {{ old('environment') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Location</label>
                    <input type="text" name="location" value="{{ old('location') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="City, Country">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Salary Range</label>
                    <input type="text" name="salary_range" value="{{ old('salary_range') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. ₦8 - 12M / Year">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Application Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Job Description</label>
                    <textarea name="description" rows="6" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Details about the role and requirements..." required>{{ old('description') }}</textarea>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Application Link (URL)</label>
                    <input type="url" name="link" value="{{ old('link') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="https://careers.company.com/apply">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Company Logo</label>
                    <div class="flex items-center gap-4 px-6 py-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <input type="file" name="logo_url" accept="image/*" class="text-xs font-bold text-gray-500 w-full">
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 p-6 rounded-2xl border border-purple-100 flex items-center gap-4 mb-8">
                <input type="checkbox" name="is_current_employee" id="current_emp" value="1" class="w-5 h-5 rounded-lg text-[var(--primary)] focus:ring-[var(--primary)] border-gray-200" {{ old('is_current_employee') ? 'checked' : '' }}>
                <label for="current_emp" class="text-sm font-bold text-[var(--primary)] leading-relaxed cursor-pointer">I verify that this is a legitimate professional opportunity.</label>
            </div>
            
            <div class="flex items-center gap-4 border-t border-gray-50 pt-10">
                <button type="submit" class="bg-[var(--primary)] text-white py-4 px-12 rounded-2xl font-bold hover:bg-[var(--primary-dark)] transition-all shadow-lg shadow-purple-100 flex items-center gap-3">
                    <i class="fas fa-paper-plane text-xs"></i> Publish Vacancy
                </button>
                <a href="{{ route('admin.jobs') }}" class="text-gray-400 font-bold hover:text-gray-600 transition-colors px-6">Discard</a>
            </div>
        </form>
    </div>
</div>
@endsection
