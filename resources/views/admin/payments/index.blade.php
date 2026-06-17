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
    <a href="{{ route('admin.payments') }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest active:scale-95 transition-all {{ !$type ? 'bg-[var(--primary)] text-white shadow-lg shadow-purple-900/20' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50 hover:border-gray-300' }}">All Payments</a>
    <a href="{{ route('admin.payments', ['type' => 'dues']) }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest active:scale-95 transition-all {{ $type == 'dues' ? 'bg-[var(--primary)] text-white shadow-lg shadow-purple-900/20' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50 hover:border-gray-300' }}">Membership Dues</a>
    <a href="{{ route('admin.payments', ['type' => 'shop']) }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest active:scale-95 transition-all {{ $type == 'shop' ? 'bg-[var(--primary)] text-white shadow-lg shadow-purple-900/20' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50 hover:border-gray-300' }}">Shop Purchases</a>
    <a href="{{ route('admin.payments', ['type' => 'donation']) }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest active:scale-95 transition-all {{ $type == 'donation' ? 'bg-[var(--primary)] text-white shadow-lg shadow-purple-900/20' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50 hover:border-gray-300' }}">Donations & Projects</a>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-8 border-b border-gray-50 bg-gray-50 bg-opacity-30 flex justify-between items-center">
        <div>
            <h3 class="text-xl font-extrabold text-gray-800">{{ $type ? ucfirst($type) . ' Ledger' : 'Global Payment Ledger' }}</h3>
            <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest">Showing {{ $payments->total() }} recorded transactions.</p>
        </div>
        <button class="bg-purple-50 text-purple-600 border border-purple-100 hover:bg-purple-600 hover:text-white px-6 py-3 rounded-2xl text-xs font-black active:scale-95 transition-all flex items-center gap-2">
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
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Method</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Status</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Date</th>
                    <th class="px-8 py-5 text-right text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Actions</th>
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
                        <div class="text-sm font-black text-[var(--primary)]">₦{{ number_format($payment->amount, 2) }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-xs font-bold text-gray-700 capitalize">{{ $payment->payment_method ?? 'gateway' }}</div>
                        @if($payment->proof_of_payment)
                            <a href="{{ asset($payment->proof_of_payment) }}" target="_blank" class="text-[9px] font-black text-secondary hover:underline flex items-center gap-1 mt-0.5">
                                <i class="fas fa-file-invoice"></i> Proof of Pay
                            </a>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @php
                            $status = strtolower($payment->status);
                            if (in_array($status, ['paid', 'success', 'successful', 'completed'])) {
                                $color = 'bg-green-50 text-green-600 border-green-100';
                            } elseif (in_array($status, ['pending'])) {
                                $color = 'bg-amber-50 text-amber-600 border-amber-100';
                            } else {
                                $color = 'bg-red-50 text-red-600 border-red-100';
                            }
                        @endphp
                        <span class="px-3 py-1 {{ $color }} text-[10px] font-black rounded-lg border uppercase tracking-tighter">
                            {{ $payment->status }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-[10px] font-bold text-gray-500 uppercase">{{ $payment->created_at->format('M d, Y') }}</div>
                        <div class="text-[9px] font-bold text-gray-300 uppercase">{{ $payment->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right text-xs font-bold">
                        @if(strtolower($payment->status) == 'pending' && $payment->payment_method == 'manual')
                            <div class="flex justify-end items-center gap-2.5">
                                <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="inline-block m-0">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200 hover:border-emerald-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider active:scale-95 transition-all cursor-pointer">
                                        <i class="fa-solid fa-circle-check text-xs"></i> Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="inline-block m-0">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 hover:border-rose-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider active:scale-95 transition-all cursor-pointer">
                                        <i class="fa-solid fa-circle-xmark text-xs"></i> Reject
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-gray-300 font-bold">-</span>
                        @endif
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

<div class="mt-12 bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-8 border-b border-gray-50 bg-gray-50 bg-opacity-30">
        <h3 class="text-xl font-extrabold text-gray-800">Manual Payment Settings</h3>
        <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest">Set bank details displayed to users when choosing Manual Bank Transfer.</p>
    </div>
    
    <div class="p-8">
        <form action="{{ route('admin.payments.settings') }}" method="POST" class="space-y-6 max-w-2xl">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Bank Name</label>
                    <input type="text" name="bank_name" value="{{ $paymentSetting->bank_name ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-2xl text-xs py-4 px-5 focus:ring-[var(--primary)] focus:border-[var(--primary)] font-bold text-gray-800" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Account Number</label>
                    <input type="text" name="account_number" value="{{ $paymentSetting->account_number ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-2xl text-xs py-4 px-5 focus:ring-[var(--primary)] focus:border-[var(--primary)] font-bold text-gray-800" required>
                </div>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Account Name</label>
                <input type="text" name="account_name" value="{{ $paymentSetting->account_name ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-2xl text-xs py-4 px-5 focus:ring-[var(--primary)] focus:border-[var(--primary)] font-bold text-gray-800" required>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Instructions</label>
                <textarea name="instructions" rows="4" class="w-full bg-gray-50 border-gray-100 rounded-2xl text-xs py-4 px-5 focus:ring-[var(--primary)] focus:border-[var(--primary)] font-medium text-gray-600" required>{{ $paymentSetting->instructions ?? '' }}</textarea>
            </div>
            
            <div>
                <button type="submit" class="bg-[var(--primary)] hover:bg-[var(--primary-dark)] text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-purple-900/20 active:scale-95 transition-all">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
