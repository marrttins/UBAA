@extends('admin.layouts.app')

@section('title', 'Order Management')

@section('content')
<div class="mb-8">
    <h3 class="text-2xl font-extrabold text-gray-800">Shop Orders</h3>
    <p class="text-gray-500 font-medium text-sm">Track and fulfill product deliveries for branch merchandise.</p>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50 bg-opacity-50">
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Order Ref</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Customer</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Items</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Delivery</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Status</th>
                    <th class="px-8 py-5 text-right text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($orders as $order)
                <tr class="hover:bg-purple-50 hover:bg-opacity-30 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap text-xs font-black text-primary uppercase">
                        #{{ $order->reference }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-sm font-extrabold text-gray-800">{{ $order->user->name }}</div>
                        <div class="text-[10px] font-bold text-gray-400">{{ $order->user->email }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="text-xs font-bold text-gray-600 max-w-[200px] truncate" title="{{ $order->items }}">
                            {{ $order->items }}
                        </div>
                        <div class="text-[10px] font-black text-secondary mt-1">₦{{ number_format($order->total_amount, 2) }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-black rounded-full uppercase tracking-tighter mb-1 inline-block">
                            {{ strtoupper($order->delivery_mode) }}
                        </span>
                        @if($order->delivery_mode == 'home')
                            <div class="text-[9px] font-bold text-gray-400 max-w-[150px] leading-tight">
                                {{ $order->delivery_address }}<br>
                                <span class="text-primary">{{ $order->delivery_phone }}</span>
                            </div>
                        @else
                            <div class="text-[9px] font-bold text-gray-400 italic">Pickup at Branch Meeting</div>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @php
                            $colors = [
                                'pending' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'shipped' => 'bg-purple-50 text-purple-600 border-purple-100',
                                'delivered' => 'bg-green-50 text-green-600 border-green-100',
                                'cancelled' => 'bg-red-50 text-red-600 border-red-100',
                            ];
                            $color = $colors[$order->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                        @endphp
                        <span class="px-3 py-1 {{ $color }} text-[10px] font-black rounded-lg border uppercase tracking-tighter">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right">
                        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="inline-flex gap-2">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="text-[10px] font-bold border-gray-100 rounded-lg focus:ring-primary focus:border-primary py-1 px-2 appearance-none bg-gray-50 cursor-pointer">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Set Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Set Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Set Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Mark Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancel Order</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-8 border-t border-gray-50 bg-gray-50 bg-opacity-30">
        {{ $orders->links() }}
    </div>
</div>
@endsection
