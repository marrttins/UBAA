@extends('admin.layouts.app')

@section('title', 'Cooperative Applications')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.cooperative') }}" class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-all">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h3 class="text-2xl font-extrabold text-gray-800">Cooperative Applications</h3>
            <p class="text-gray-500 font-medium text-sm">Review and manage membership applications.</p>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
    @php
        $pending = $applications->where('status', 'pending')->count();
        $contacted = $applications->where('status', 'contacted')->count();
        $approved = $applications->where('status', 'approved')->count();
        $rejected = $applications->where('status', 'rejected')->count();
    @endphp
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600">
            <i class="fas fa-clock text-sm"></i>
        </div>
        <div>
            <p class="text-lg font-extrabold text-gray-800">{{ $pending }}</p>
            <p class="text-[10px] text-gray-500 font-bold uppercase">Pending</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
            <i class="fas fa-phone text-sm"></i>
        </div>
        <div>
            <p class="text-lg font-extrabold text-gray-800">{{ $contacted }}</p>
            <p class="text-[10px] text-gray-500 font-bold uppercase">Contacted</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
            <i class="fas fa-check text-sm"></i>
        </div>
        <div>
            <p class="text-lg font-extrabold text-gray-800">{{ $approved }}</p>
            <p class="text-[10px] text-gray-500 font-bold uppercase">Approved</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-600">
            <i class="fas fa-times text-sm"></i>
        </div>
        <div>
            <p class="text-lg font-extrabold text-gray-800">{{ $rejected }}</p>
            <p class="text-[10px] text-gray-500 font-bold uppercase">Rejected</p>
        </div>
    </div>
</div>

{{-- Applications List --}}
<div class="space-y-4">
    @forelse($applications as $application)
    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all">
        <div class="flex items-start justify-between gap-6">
            <div class="flex items-start gap-4 flex-1">
                <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-[var(--primary)] font-black text-lg flex-shrink-0">
                    {{ substr($application->full_name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-1">
                        <h4 class="font-extrabold text-gray-800">{{ $application->full_name }}</h4>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold
                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $application->status === 'contacted' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $application->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                        ">{{ ucfirst($application->status) }}</span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Email</p>
                            <p class="text-sm text-gray-700 font-medium">{{ $application->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Phone</p>
                            <p class="text-sm text-gray-700 font-medium">{{ $application->phone }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Occupation</p>
                            <p class="text-sm text-gray-700 font-medium">{{ $application->occupation ?? '---' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Applied</p>
                            <p class="text-sm text-gray-700 font-medium">{{ $application->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    @if($application->matric_number || $application->graduation_year)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Matric No.</p>
                            <p class="text-sm text-gray-700 font-medium">{{ $application->matric_number ?? '---' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Graduation Year</p>
                            <p class="text-sm text-gray-700 font-medium">{{ $application->graduation_year ?? '---' }}</p>
                        </div>
                    </div>
                    @endif

                    @if($application->address)
                    <div class="mt-3">
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Address</p>
                        <p class="text-sm text-gray-700 font-medium">{{ $application->address }}</p>
                    </div>
                    @endif

                    @if($application->reason)
                    <div class="mt-3 bg-gray-50 rounded-xl p-4">
                        <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Reason for Joining</p>
                        <p class="text-sm text-gray-700 font-medium">{{ $application->reason }}</p>
                    </div>
                    @endif

                    @if($application->admin_notes)
                    <div class="mt-3 bg-purple-50 rounded-xl p-4">
                        <p class="text-[10px] text-purple-400 font-bold uppercase mb-1">Admin Notes</p>
                        <p class="text-sm text-purple-700 font-medium">{{ $application->admin_notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Status Update Form --}}
            <div class="flex-shrink-0 w-64">
                <form action="{{ route('admin.cooperative.applications.status', $application) }}" method="POST" class="space-y-3">
                    @csrf
                    <select name="status" class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl text-sm font-semibold text-gray-700 focus:ring-2 focus:ring-purple-200">
                        <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="contacted" {{ $application->status === 'contacted' ? 'selected' : '' }}>📞 Contacted</option>
                        <option value="approved" {{ $application->status === 'approved' ? 'selected' : '' }}>✅ Approved</option>
                        <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                    </select>
                    <textarea name="admin_notes" rows="2" class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl text-xs font-medium text-gray-700 focus:ring-2 focus:ring-purple-200" placeholder="Admin notes...">{{ $application->admin_notes }}</textarea>
                    <button type="submit" class="w-full bg-[var(--primary)] text-white py-2 px-4 rounded-xl font-bold text-xs hover:brightness-110 transition-all">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-16 text-center">
        <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-300 text-3xl mx-auto mb-4">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <p class="text-gray-400 font-bold">No applications received yet</p>
        <p class="text-sm text-gray-400 mt-2">Applications will appear here when users submit the cooperative join form.</p>
    </div>
    @endforelse
</div>

@if($applications->hasPages())
<div class="mt-8">
    {{ $applications->links() }}
</div>
@endif
@endsection
