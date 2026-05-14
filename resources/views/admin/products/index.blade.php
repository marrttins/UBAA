@extends('admin.layouts.app')

@section('title', 'Shop Management')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-extrabold text-gray-800">Branch Shop</h3>
        <p class="text-gray-500 font-medium text-sm">Manage products, souvenirs and merchandise for the alumni store.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.products.create') }}" class="bg-[var(--primary)] text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-purple-100 hover:bg-[var(--primary-dark)] transition-all flex items-center gap-2">
            <i class="fas fa-plus-circle text-xs"></i> Add New Product
        </a>
    </div>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50 bg-opacity-50">
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Product Details</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Category</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Price</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Badge</th>
                    <th class="px-8 py-5 text-right text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($products as $product)
                <tr class="hover:bg-purple-50 hover:bg-opacity-30 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-4">
                            <div class="h-16 w-16 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300 shadow-sm border-2 border-white overflow-hidden">
                                @if($product->image_url)
                                    <img src="{{ str_starts_with($product->image_url, 'http') ? $product->image_url : asset($product->image_url) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-box-open"></i>
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-extrabold text-gray-800">{{ $product->title }}</div>
                                @if($product->is_spotlight)
                                    <span class="text-[9px] bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full font-black uppercase tracking-tighter">Spotlight</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-extrabold rounded-full bg-purple-50 text-[var(--primary)] border border-purple-100 uppercase tracking-widest">
                            {{ $product->category ?? 'Souvenir' }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-700">
                        ₦{{ number_format($product->price, 0) }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($product->badge)
                            <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-lg border border-green-100 uppercase tracking-tighter">{{ $product->badge }}</span>
                        @else
                            <span class="text-gray-300 text-[10px] font-bold">None</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center gap-2 text-[var(--primary)] hover:text-[var(--primary-dark)] bg-purple-50 px-3 py-1.5 rounded-lg transition-all font-bold">
                                <i class="fas fa-edit text-xs"></i> Edit
                            </a>
                            <form action="{{ route('admin.products.delete', $product) }}" method="POST" onsubmit="return confirm('Delete this product permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-2 text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition-all font-bold">
                                    <i class="fas fa-trash text-xs"></i>
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
        {{ $products->links() }}
    </div>
</div>
@endsection
