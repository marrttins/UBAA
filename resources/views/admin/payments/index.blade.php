@extends('admin.layouts.app')

@section('title', 'Financial Oversight')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-[32px] border border-gray-50 shadow-sm flex flex-col justify-between overflow-hidden relative group">
        <div class="relative z-10">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Total Revenue</p>
            <h4 class="text-2xl font-black text-gray-800">₦{{ number_format($totalRevenue, 2) }}</h4>
        </div>
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-110 transition-transform flex items-center justify-center p-6 opacity-50">
            <i class="fas fa-vault text-2xl text-purple-200"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[32px] border border-gray-50 shadow-sm flex flex-col justify-between overflow-hidden relative group">
        <div class="relative z-10">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Membership Dues</p>
            <h4 class="text-2xl font-black text-primary">₦{{ number_format($duesRevenue, 2) }}</h4>
        </div>
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-110 transition-transform flex items-center justify-center p-6 opacity-50">
            <i class="fas fa-id-card text-2xl text-blue-200"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[32px] border border-gray-50 shadow-sm flex flex-col justify-between overflow-hidden relative group">
        <div class="relative z-10">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Shop Sales</p>
            <h4 class="text-2xl font-black text-secondary">₦{{ number_format($shopRevenue, 2) }}</h4>
        </div>
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-yellow-50 rounded-full group-hover:scale-110 transition-transform flex items-center justify-center p-6 opacity-50">
            <i class="fas fa-shopping-bag text-2xl text-yellow-200"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[32px] border border-gray-50 shadow-sm flex flex-col justify-between overflow-hidden relative group">
        <div class="relative z-10">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Donations/Project</p>
            <h4 class="text-2xl font-black text-green-600">₦{{ number_format($donationRevenue, 2) }}</h4>
        </div>
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-50 rounded-full group-hover:scale-110 transition-transform flex items-center justify-center p-6 opacity-50">
            <i class="fas fa-hand-holding-heart text-2xl text-green-200"></i>
        </div>
    </div>
</div>

<div class="mb-8 flex flex-wrap gap-3">
    <a href="{{ route('admin.payments') }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ !$type ? 'bg-primary text-white shadow-lg' : 'bg-white text-gray-400 border border-gray-50 hover:bg-gray-50' }}">All Payments</a>
    <a href="{{ route('admin.payments', ['type' => 'dues']) }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ $type == 'dues' ? 'bg-primary text-white shadow-lg' : 'bg-white text-gray-400 border border-gray-50 hover:bg-gray-50' }}">Membership Dues</a>
    <a href="{{ route('admin.payments', ['type' => 'shop']) }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ $type == 'shop' ? 'bg-primary text-white shadow-lg' : 'bg-white text-gray-400 border border-gray-50 hover:bg-gray-50' }}">Shop Purchases</a>
    <a href="{{ route('admin.payments', ['type' => 'donation']) }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ $type == 'donation' ? 'bg-primary text-white shadow-lg' : 'bg-white text-gray-400 border border-gray-50 hover:bg-gray-50' }}">Donations & Projects</a>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-8 border-b border-gray-50 bg-gray-50 bg-opacity-30 flex justify-between items-center">
        <div>
            <h3 class="text-xl font-extrabold text-gray-800">{{ $type ? ucfirst($type) . ' Ledger' : 'Global Payment Ledger' }}</h3>
            <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest">Showing {{ $payments->total() }} recorded transactions.</p>
        </div>
        <button class="bg-purple-50 text-purple-600 px-6 py-3 rounded-2xl text-xs font-black hover:bg-purple-100 transition-all flex items-center gap-2">
            <i class="fas fa-file-export"></i> Export CSV
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50 bg-opacity-30">
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Transaction</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Member</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Amount</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Reference</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Status</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($payments as $payment)
                <tr class="hover:bg-gray-50 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xs border border-purple-100 group-hover:bg-purple-600 group-hover:text-white transition-all">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div class="text-xs font-black text-gray-800 truncate max-w-[200px]" title="{{ $payment->description }}">
                                {{ $payment->description }}
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($payment->user)
                            <div class="text-xs font-black text-gray-800">{{ $payment->user->name }}</div>
                            <div class="text-[9px] font-bold text-gray-400">{{ $payment->user->email }}</div>
                        @else
                            <span class="text-xs font-bold text-red-400 italic">User Deleted</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-sm font-black text-primary">₦{{ number_format($payment->amount, 2) }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-[10px] font-black text-gray-400 font-mono tracking-tighter uppercase">{{ $payment->reference }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @php
                            $isSuccess = in_array(strtolower($payment->status), ['paid', 'success', 'successful', 'completed']);
                            $color = $isSuccess ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100';
                        @endphp
                        <span class="px-3 py-1 {{ $color }} text-[10px] font-black rounded-lg border uppercase tracking-tighter">
                            {{ $payment->status }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-[10px] font-bold text-gray-500 uppercase">{{ $payment->created_at->format('M d, Y') }}</div>
                        <div class="text-[9px] font-bold text-gray-300 uppercase">{{ $payment->created_at->format('h:i A') }}</div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-8 border-t border-gray-50 bg-gray-50 bg-opacity-30">
        {{ $payments->appends(request()->query())->links() }}
    </div>
</div>
@endsection
