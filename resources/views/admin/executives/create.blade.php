@extends('admin.layouts.app')

@section('title', 'Assign Executive Role')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.executives') }}" class="text-[var(--primary)] font-bold text-sm flex items-center gap-2 hover:translate-x-[-5px] transition-transform">
            <i class="fas fa-arrow-left text-xs"></i> Back to Executives
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 bg-gray-50 bg-opacity-30">
            <h3 class="text-2xl font-extrabold text-gray-800">Add Executive Role</h3>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-[2px]">Select an existing member and assign them an administrative or custom executive role.</p>
        </div>

        <form action="{{ route('admin.executives.store') }}" method="POST" class="p-10">
            @csrf
            <div class="space-y-8 mb-10">
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Select Member</label>
                    <div class="relative">
                        <i class="fas fa-user-friends absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <select name="user_id" class="w-full pl-12 pr-12 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none" required>
                            <option value="" disabled selected>Select a member...</option>
                            @foreach($regularUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"></i>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Administrative Role</label>
                    <div class="relative">
                        <i class="fas fa-user-shield absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <select name="role" id="roleSelect" class="w-full pl-12 pr-12 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none" required>
                            <option value="admin">General Admin</option>
                            <option value="chairman">Branch Chairman</option>
                            <option value="vice_chairman">Vice Chairman</option>
                            <option value="secretary">Branch Secretary</option>
                            <option value="legal">Branch Legal Adviser</option>
                            <option value="welfare">Welfare Secretary</option>
                            <option value="pro">Public Relations Officer (PRO)</option>
                            <option value="pro_ii">PRO II</option>
                            <option value="custom">-- Custom Executive Role --</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"></i>
                    </div>
                </div>

                <div id="customRoleBlock" class="space-y-2 hidden">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Custom Role Title</label>
                    <div class="relative">
                        <i class="fas fa-id-badge absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <input type="text" name="custom_role" id="customRoleInput" class="w-full pl-12 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. Assistant Secretary">
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider pl-1">This role will be created and assigned to the selected member.</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 border-t border-gray-50 pt-10">
                <button type="submit" class="bg-[var(--primary)] text-white py-4 px-10 rounded-2xl font-bold hover:bg-[var(--primary-dark)] active:scale-95 transition-all shadow-lg shadow-purple-100 flex items-center gap-3">
                    <i class="fas fa-check-circle text-xs"></i> Assign Role
                </button>
                <a href="{{ route('admin.executives') }}" class="text-gray-400 font-bold hover:text-gray-600 transition-colors px-6">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('extra_js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('roleSelect');
        const customRoleBlock = document.getElementById('customRoleBlock');
        const customRoleInput = document.getElementById('customRoleInput');

        if (roleSelect) {
            roleSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customRoleBlock.classList.remove('hidden');
                    customRoleInput.required = true;
                    customRoleInput.focus();
                } else {
                    customRoleBlock.classList.add('hidden');
                    customRoleInput.required = false;
                    customRoleInput.value = '';
                }
            });
        }
    });
</script>
@endsection
