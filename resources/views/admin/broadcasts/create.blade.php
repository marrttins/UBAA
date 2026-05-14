@extends('admin.layouts.app')

@section('title', 'Compose Broadcast')

@section('extra_css')
<style>
    .user-checkbox:checked + .user-card {
        border-color: #4A0E4E;
        background: #f8f4f9;
        box-shadow: 0 0 0 2px #4A0E4E;
    }
    .user-checkbox:checked + .user-card .check-icon {
        display: flex;
    }
    .user-card .check-icon {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.broadcasts') }}" class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-all">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h3 class="text-2xl font-extrabold text-gray-800">Compose Broadcast Email</h3>
            <p class="text-gray-500 font-medium text-sm">Send email to all members or selected recipients.</p>
        </div>
    </div>

    <form action="{{ route('admin.broadcasts.send') }}" method="POST" id="broadcastForm">
        @csrf
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden p-10">
            <div class="space-y-8">
                {{-- Subject --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Email Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. Important Update from UBAA Lagos" required>
                </div>

                {{-- Message --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Message Body</label>
                    <textarea name="message" rows="8" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Type your message here..." required>{{ old('message') }}</textarea>
                </div>

                {{-- Recipient Type --}}
                <div class="space-y-4">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Recipients</label>
                    <div class="flex gap-4">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="recipient_type" value="all" class="peer hidden" checked onchange="toggleRecipientList()">
                            <div class="peer-checked:border-[var(--primary)] peer-checked:bg-purple-50 peer-checked:shadow-lg peer-checked:shadow-purple-100 border-2 border-gray-200 rounded-2xl p-5 transition-all hover:border-gray-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                                        <i class="fas fa-users text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-gray-800">All Members</p>
                                        <p class="text-xs text-gray-500 font-medium">Send to all {{ $users->count() }} registered members</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="recipient_type" value="selected" class="peer hidden" onchange="toggleRecipientList()">
                            <div class="peer-checked:border-[var(--primary)] peer-checked:bg-purple-50 peer-checked:shadow-lg peer-checked:shadow-purple-100 border-2 border-gray-200 rounded-2xl p-5 transition-all hover:border-gray-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                                        <i class="fas fa-user-check text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-gray-800">Selected Members</p>
                                        <p class="text-xs text-gray-500 font-medium">Choose specific members to send to</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- User Selection (hidden by default) --}}
                <div id="recipientList" class="hidden space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Select Recipients</label>
                        <div class="flex gap-3">
                            <button type="button" onclick="selectAll()" class="text-xs font-bold text-[var(--primary)] hover:underline">Select All</button>
                            <button type="button" onclick="deselectAll()" class="text-xs font-bold text-gray-400 hover:underline">Deselect All</button>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <input type="text" id="searchUsers" onkeyup="filterUsers()" class="w-full px-6 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-purple-200 transition-all font-medium text-gray-700 text-sm" placeholder="🔍 Search members by name or email...">
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-[400px] overflow-y-auto p-1" id="userGrid">
                        @foreach($users as $user)
                        <label class="cursor-pointer user-label" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}">
                            <input type="checkbox" name="recipient_ids[]" value="{{ $user->id }}" class="hidden user-checkbox">
                            <div class="user-card border-2 border-gray-100 rounded-xl p-4 transition-all hover:border-gray-200 relative">
                                <div class="check-icon absolute top-2 right-2 w-6 h-6 rounded-full bg-[var(--primary)] text-white items-center justify-center text-xs">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($user->avatar_url)
                                        <img class="h-9 w-9 rounded-lg object-cover" src="{{ asset($user->avatar_url) }}" alt="">
                                    @else
                                        <div class="h-9 w-9 rounded-lg bg-purple-100 flex items-center justify-center text-[var(--primary)] font-bold text-sm">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-bold text-gray-700 text-xs truncate">{{ $user->name }}</p>
                                        <p class="text-[10px] text-gray-400 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    
                    <p class="text-xs text-gray-400 font-medium px-2" id="selectedCount">0 members selected</p>
                </div>
            </div>

            <div class="mt-10 pt-10 border-t border-gray-50 flex justify-between items-center">
                <p class="text-xs text-gray-400 font-medium">
                    <i class="fas fa-info-circle mr-1"></i> Emails will be sent immediately after submission.
                </p>
                <button type="submit" class="bg-[var(--primary)] text-white py-4 px-12 rounded-2xl font-bold hover:brightness-110 transition-all shadow-xl shadow-purple-100 flex items-center gap-3">
                    <i class="fas fa-paper-plane text-xs"></i> Send Broadcast
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('extra_js')
<script>
function toggleRecipientList() {
    const selected = document.querySelector('input[name="recipient_type"]:checked').value;
    const list = document.getElementById('recipientList');
    list.style.display = selected === 'selected' ? 'block' : 'none';
}

function selectAll() {
    document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = true);
    updateCount();
}

function deselectAll() {
    document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = false);
    updateCount();
}

function updateCount() {
    const count = document.querySelectorAll('.user-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = count + ' members selected';
}

function filterUsers() {
    const query = document.getElementById('searchUsers').value.toLowerCase();
    document.querySelectorAll('.user-label').forEach(label => {
        const name = label.getAttribute('data-name');
        const email = label.getAttribute('data-email');
        label.style.display = (name.includes(query) || email.includes(query)) ? '' : 'none';
    });
}

// Update count on checkbox change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('user-checkbox')) {
        updateCount();
    }
});
</script>
@endsection
