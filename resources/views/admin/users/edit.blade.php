@extends('admin.layouts.app')

@section('title', 'Edit Member Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.users') }}" class="text-[var(--primary)] font-bold text-sm flex items-center gap-2 hover:translate-x-[-5px] transition-transform">
            <i class="fas fa-arrow-left text-xs"></i> Back to Directory
        </a>
    </div>

    <div class="bg-white rounded-[24px] md:rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-10 border-b border-gray-50 flex flex-col sm:flex-row items-center text-center sm:text-left gap-4 sm:gap-6 bg-gray-50 bg-opacity-30">
            @if($user->avatar_url)
                <img class="h-20 w-20 rounded-[24px] object-cover shadow-md border-4 border-white" src="{{ asset($user->avatar_url) }}" alt="">
            @else
                <div class="h-20 w-20 rounded-[24px] bg-purple-100 flex items-center justify-center text-[var(--primary)] text-2xl font-black shadow-md border-4 border-white">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif
            <div>
                <h3 class="text-2xl font-extrabold text-gray-800">{{ $user->name }}</h3>
                <p class="text-gray-500 font-bold text-xs uppercase tracking-[2px]">{{ $user->email }}</p>
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 md:p-10">
            @csrf
            
            <!-- Section: Personal Information -->
            <div class="mb-12">
                <h4 class="text-[var(--primary)] font-black text-xs uppercase tracking-[3px] mb-8 flex items-center gap-3">
                    <span class="w-8 h-px bg-purple-100"></span> Personal Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', $user->title) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. Dr., Prof.">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                    </div>
                </div>
            </div>

            <!-- Section: Academic Details -->
            <div class="mb-12">
                <h4 class="text-[var(--primary)] font-black text-xs uppercase tracking-[3px] mb-8 flex items-center gap-3">
                    <span class="w-8 h-px bg-purple-100"></span> Academic Profile
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Matric Number</label>
                        <input type="text" name="matric_number" value="{{ old('matric_number', $user->matric_number) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Primary Degree</label>
                        <input type="text" name="degree" value="{{ old('degree', $user->degree) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. B.Sc Computer Science">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Graduation Year</label>
                        <input type="number" name="graduation_year" value="{{ old('graduation_year', $user->graduation_year) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Alumni ID</label>
                        <input type="text" name="alumni_id" value="{{ old('alumni_id', $user->alumni_id) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                    </div>
                </div>
            </div>

            <!-- Section: Professional & Social -->
            <div class="mb-12">
                <h4 class="text-[var(--primary)] font-black text-xs uppercase tracking-[3px] mb-8 flex items-center gap-3">
                    <span class="w-8 h-px bg-purple-100"></span> Career & Social
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Job Title</label>
                        <input type="text" name="job_title" value="{{ old('job_title', $user->job_title) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Company</label>
                        <input type="text" name="company" value="{{ old('company', $user->company) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Current Location</label>
                        <input type="text" name="location" value="{{ old('location', $user->location) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="relative">
                        <i class="fab fa-linkedin absolute left-4 top-1/2 -translate-y-1/2 text-blue-600"></i>
                        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}" class="w-full pl-10 pr-4 py-3 bg-gray-50 border-none rounded-xl text-xs font-semibold" placeholder="LinkedIn URL">
                    </div>
                    <div class="relative">
                        <i class="fab fa-facebook absolute left-4 top-1/2 -translate-y-1/2 text-blue-800"></i>
                        <input type="url" name="facebook_url" value="{{ old('facebook_url', $user->facebook_url) }}" class="w-full pl-10 pr-4 py-3 bg-gray-50 border-none rounded-xl text-xs font-semibold" placeholder="Facebook URL">
                    </div>
                    <div class="relative">
                        <i class="fab fa-twitter absolute left-4 top-1/2 -translate-y-1/2 text-blue-400"></i>
                        <input type="url" name="twitter_url" value="{{ old('twitter_url', $user->twitter_url) }}" class="w-full pl-10 pr-4 py-3 bg-gray-50 border-none rounded-xl text-xs font-semibold" placeholder="Twitter URL">
                    </div>
                    <div class="relative">
                        <i class="fab fa-instagram absolute left-4 top-1/2 -translate-y-1/2 text-pink-600"></i>
                        <input type="url" name="instagram_url" value="{{ old('instagram_url', $user->instagram_url) }}" class="w-full pl-10 pr-4 py-3 bg-gray-50 border-none rounded-xl text-xs font-semibold" placeholder="Instagram URL">
                    </div>
                </div>
            </div>

            <!-- Section: Administrative -->
            <div class="mb-12">
                <h4 class="text-[var(--primary)] font-black text-xs uppercase tracking-[3px] mb-8 flex items-center gap-3">
                    <span class="w-8 h-px bg-purple-100"></span> Administration & Access
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Account Role</label>
                        <select name="role" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Regular Member</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>General Admin</option>
                            <option value="chairman" {{ $user->role == 'chairman' ? 'selected' : '' }}>Branch Chairman</option>
                            <option value="vice_chairman" {{ $user->role == 'vice_chairman' ? 'selected' : '' }}>Vice Chairman</option>
                            <option value="secretary" {{ $user->role == 'secretary' ? 'selected' : '' }}>Branch Secretary</option>
                            <option value="legal" {{ $user->role == 'legal' ? 'selected' : '' }}>Branch Legal Adviser</option>
                            <option value="welfare" {{ $user->role == 'welfare' ? 'selected' : '' }}>Welfare Secretary</option>
                            <option value="pro" {{ $user->role == 'pro' ? 'selected' : '' }}>Public Relations Officer (PRO)</option>
                            <option value="pro_ii" {{ $user->role == 'pro_ii' ? 'selected' : '' }}>PRO II</option>
                            @if(!in_array($user->role, ['user', 'admin', 'chairman', 'vice_chairman', 'secretary', 'legal', 'welfare', 'pro', 'pro_ii']))
                                <option value="{{ $user->role }}" selected>{{ ucwords(str_replace('_', ' ', $user->role)) }} (Custom Role)</option>
                            @endif
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Membership Type</label>
                        <select name="membership_type" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                            <option value="Standard" {{ $user->membership_type == 'Standard' ? 'selected' : '' }}>Standard Member</option>
                            <option value="Premium" {{ $user->membership_type == 'Premium' ? 'selected' : '' }}>Premium Member</option>
                            <option value="Life" {{ $user->membership_type == 'Life' ? 'selected' : '' }}>Life Member</option>
                        </select>
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Bio / Personal Statement</label>
                        <textarea name="bio" rows="4" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-4 border-t border-gray-50 pt-10">
                <button type="submit" class="w-full sm:w-auto bg-[var(--primary)] text-white py-4 px-12 rounded-2xl font-bold hover:bg-[var(--primary-dark)] active:scale-95 transition-all shadow-lg shadow-purple-100 flex items-center justify-center gap-3">
                    <i class="fas fa-check-circle text-xs"></i> Update Member Record
                </button>
                @if($user->id !== auth()->id())
                <button type="button" onclick="confirmDelete()" class="w-full sm:w-auto bg-red-600 text-white py-4 px-12 rounded-2xl font-bold hover:bg-red-700 active:scale-95 transition-all shadow-lg shadow-red-100 flex items-center justify-center gap-3 md:ml-auto">
                    <i class="fas fa-trash-alt text-xs"></i> Delete Account
                </button>
                @endif
                <a href="{{ $user->role === 'user' ? route('admin.users') : route('admin.executives') }}" class="w-full sm:w-auto text-center text-gray-400 font-bold hover:text-gray-600 transition-colors py-3 px-6">Discard Changes</a>
            </div>
        </form>
    </div>
</div>

@if($user->id !== auth()->id())
<form id="deleteUserForm" action="{{ route('admin.users.delete', $user) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    function confirmDelete() {
        if (confirm('Are you absolutely sure you want to delete this user? This action is permanent and cannot be undone.')) {
            document.getElementById('deleteUserForm').submit();
        }
    }
</script>
@endif
@endsection
