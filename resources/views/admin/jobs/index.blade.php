@extends('admin.layouts.app')

@section('title', 'Job Board')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-extrabold text-gray-800">Career Opportunities</h3>
        <p class="text-gray-500 font-medium text-sm">Moderate and manage job listings for alumni career growth.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.jobs.create') }}" class="bg-[var(--primary)] text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-purple-100 hover:bg-[var(--primary-dark)] transition-all flex items-center gap-2">
            <i class="fas fa-plus-square text-xs"></i> Post New Vacancy
        </a>
    </div>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50 bg-opacity-50">
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Job & Company</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Work Type</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Deadline</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Posting Info</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Status</th>
                    <th class="px-8 py-5 text-right text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($jobs as $job)
                <tr class="hover:bg-purple-50 hover:bg-opacity-30 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-2xl bg-yellow-50 flex items-center justify-center text-[var(--secondary)] shadow-sm border-2 border-white">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div>
                                <div class="text-sm font-extrabold text-gray-800">{{ $job->title }}</div>
                                <div class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">{{ $job->company }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-extrabold rounded-full bg-gray-50 text-gray-600 border border-gray-100 uppercase tracking-widest capitalize">
                            {{ $job->environment }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                        {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('M d, Y') : 'Ongoing' }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                        {{ $job->created_at->format('M d, Y') }}<br>
                        <span class="text-[10px] text-gray-400">By: {{ $job->user->name ?? 'Admin' }}</span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($job->status === 'approved')
                            <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-lg border border-green-100 uppercase tracking-tighter">Approved</span>
                        @elseif($job->status === 'pending')
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-600 text-[10px] font-black rounded-lg border border-yellow-100 uppercase tracking-tighter">Pending</span>
                        @else
                            <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black rounded-lg border border-red-100 uppercase tracking-tighter">Rejected</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right">
                            <div class="flex justify-end gap-2">
                                @if($job->status === 'pending')
                                    <form action="{{ route('admin.jobs.approve', $job) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition text-xs font-bold" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.jobs.reject', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this job?');">
                                        @csrf
                                        <button type="submit" class="bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600 transition text-xs font-bold" title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.jobs.delete', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job posting permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition text-xs font-bold" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-8 border-t border-gray-50 bg-gray-50 bg-opacity-30">
        {{ $jobs->links() }}
    </div>
</div>
@endsection
