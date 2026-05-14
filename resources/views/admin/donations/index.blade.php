@extends('admin.layouts.app')

@section('title', 'Donation Projects')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h3 class="text-2xl font-extrabold text-gray-800">Donation Projects</h3>
        <p class="text-gray-500 font-medium text-sm">Manage fundraising campaigns and causes.</p>
    </div>
    <a href="{{ route('admin.donations.create') }}" class="bg-[var(--primary)] text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-lg hover:brightness-110 transition-all flex items-center gap-2">
        <i class="fas fa-plus text-xs"></i> New Project
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($projects as $project)
    <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden flex flex-col group hover:shadow-xl transition-all duration-300">
        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-xl border border-purple-100 group-hover:bg-purple-600 group-hover:text-white transition-all">
                    <i class="fas {{ $project->icon }}"></i>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.donations.edit', $project) }}" class="p-2 bg-gray-50 text-gray-400 hover:text-primary rounded-lg transition-colors"><i class="fas fa-edit text-xs"></i></a>
                    <form action="{{ route('admin.donations.delete', $project) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 bg-gray-50 text-gray-400 hover:text-red-500 rounded-lg transition-colors"><i class="fas fa-trash text-xs"></i></button>
                    </form>
                </div>
            </div>
            <h4 class="font-black text-gray-800 text-lg mb-2">{{ $project->title }}</h4>
            <p class="text-xs text-gray-500 line-clamp-3 leading-relaxed mb-6">{{ $project->description }}</p>
            
            <div class="space-y-3">
                <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-gray-400">
                    <span>Goal: ₦{{ number_format($project->goal_amount) }}</span>
                    @php $percent = $project->goal_amount > 0 ? round(($project->raised_amount / $project->goal_amount) * 100) : 0; @endphp
                    <span class="text-primary">{{ $percent }}%</span>
                </div>
                <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-primary h-full transition-all duration-1000" style="width: {{ min(100, $percent) }}%"></div>
                </div>
                <p class="text-[10px] font-bold text-gray-400 text-center uppercase tracking-tighter">Raised: <span class="text-gray-800 font-black">₦{{ number_format($project->raised_amount) }}</span></p>
            </div>
        </div>
        <div class="mt-auto p-6 bg-gray-50 flex items-center justify-center border-t border-gray-100">
             <span class="text-[10px] font-black uppercase tracking-widest {{ $project->is_active ? 'text-green-500' : 'text-red-400' }}">
                 {{ $project->is_active ? 'Campaign Active' : 'Campaign Paused' }}
             </span>
        </div>
    </div>
    @endforeach
</div>
@endsection
