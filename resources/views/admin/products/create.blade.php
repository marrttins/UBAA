@extends('admin.layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.products') }}" class="text-[var(--primary)] font-bold text-sm flex items-center gap-2 hover:translate-x-[-5px] transition-transform">
            <i class="fas fa-arrow-left text-xs"></i> Back to Shop Manager
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 bg-gray-50 bg-opacity-30">
            <h3 class="text-2xl font-extrabold text-gray-800">New Product</h3>
            <p class="text-gray-500 font-bold text-xs uppercase tracking-[2px]">Add a new souvenir or merchandise to the alumni store.</p>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Product Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. UNIBEN Branded Hoodie" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Sales Price (Was) (₦)</label>
                    <input type="number" name="original_price" value="{{ old('original_price') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. 15000">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Current Amount (Now) (₦)</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. 12000" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Available Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity', 0) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. 50">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Delivery Fee (₦)</label>
                    <input type="number" name="delivery_fee" value="{{ old('delivery_fee', 3500) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. 3500">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Category</label>
                    <select name="category" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                        <option value="Apparel">Apparel</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Kitchen tools">Kitchen tools</option>
                        <option value="food">Food</option>
                        <option value="gift">Gift</option>
                        <option value="fashion">Fashion</option>
                    </select>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Available Sizes</label>
                    <div class="flex gap-6 px-4">
                        <label class="flex items-center gap-2 cursor-pointer font-bold text-gray-600">
                            <input type="checkbox" name="sizes[]" value="Small" class="rounded text-[var(--primary)] focus:ring-[var(--primary)]"> Small
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer font-bold text-gray-600">
                            <input type="checkbox" name="sizes[]" value="Medium" class="rounded text-[var(--primary)] focus:ring-[var(--primary)]"> Medium
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer font-bold text-gray-600">
                            <input type="checkbox" name="sizes[]" value="Large" class="rounded text-[var(--primary)] focus:ring-[var(--primary)]"> Large
                        </label>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Badge (Optional)</label>
                    <select name="badge" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                        <option value="">None</option>
                        <option value="New">New Arrival</option>
                        <option value="Limited">Limited Edition</option>
                        <option value="Best Seller">Best Seller</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Product Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Product Description</label>
                    <textarea name="description" rows="4" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Tell users more about this product...">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="bg-purple-50 p-6 rounded-2xl border border-purple-100 flex items-center gap-4 mb-8">
                <input type="checkbox" name="is_spotlight" id="spotlight" value="1" class="w-5 h-5 rounded-lg text-[var(--primary)] focus:ring-[var(--primary)] border-gray-200">
                <label for="spotlight" class="text-sm font-bold text-[var(--primary)] leading-relaxed cursor-pointer">Feature this product in spotlight sections.</label>
            </div>
            
            <div class="flex items-center gap-4 border-t border-gray-50 pt-10">
                <button type="submit" class="bg-[var(--primary)] text-white py-4 px-12 rounded-2xl font-bold hover:bg-[var(--primary-dark)] transition-all shadow-lg shadow-purple-100 flex items-center gap-3">
                    <i class="fas fa-save text-xs"></i> Save Product
                </button>
                <a href="{{ route('admin.products') }}" class="text-gray-400 font-bold hover:text-gray-600 transition-colors px-6">Discard</a>
            </div>
        </form>
    </div>
</div>
@endsection
