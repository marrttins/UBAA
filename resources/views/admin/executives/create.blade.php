@extends('admin.layouts.app')

@section('title', 'Create Executive Account')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.executives') }}" class="text-[var(--primary)] font-bold text-sm flex items-center gap-2 hover:translate-x-[-5px] transition-transform">
            <i class="fas fa-arrow-left text-xs"></i> Back to Executives
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 bg-gray-50 bg-opacity-30">
            <h3 class="text-2xl font-extrabold text-gray-800">New Executive</h3>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-[2px]">Create a new administrative user with specific role permissions.</p>
        </div>

        <form action="{{ route('admin.executives.store') }}" method="POST" class="p-10">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">First Name</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full pl-12 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="John" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Last Name</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full pl-12 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Doe" required>
                    </div>
                </div>
                
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full pl-12 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="executive@ubaa.com" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <input type="password" name="password" class="w-full pl-12 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Confirm Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <input type="password" name="password_confirmation" class="w-full pl-12 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="••••••••" required>
                    </div>
                </div>
                
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Administrative Role</label>
                    <div class="relative">
                        <i class="fas fa-user-shield absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <select name="role" class="w-full pl-12 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>General Admin</option>
                            <option value="chairman" {{ old('role') == 'chairman' ? 'selected' : '' }}>Branch Chairman</option>
                            <option value="vice_chairman" {{ old('role') == 'vice_chairman' ? 'selected' : '' }}>Vice Chairman</option>
                            <option value="secretary" {{ old('role') == 'secretary' ? 'selected' : '' }}>Branch Secretary</option>
                            <option value="legal" {{ old('role') == 'legal' ? 'selected' : '' }}>Branch Legal Adviser</option>
                            <option value="welfare" {{ old('role') == 'welfare' ? 'selected' : '' }}>Welfare Secretary</option>
                            <option value="pro" {{ old('role') == 'pro' ? 'selected' : '' }}>Public Relations Officer (PRO)</option>
                            <option value="pro_ii" {{ old('role') == 'pro_ii' ? 'selected' : '' }}>PRO II</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"></i>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-4 border-t border-gray-50 pt-10">
                <button type="submit" class="bg-[var(--primary)] text-white py-4 px-10 rounded-2xl font-bold hover:bg-[var(--primary-dark)] transition-all shadow-lg shadow-purple-100 flex items-center gap-3">
                    <i class="fas fa-save text-xs"></i> Create Executive
                </button>
                <a href="{{ route('admin.executives') }}" class="text-gray-400 font-bold hover:text-gray-600 transition-colors px-6">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
