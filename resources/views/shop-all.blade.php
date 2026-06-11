<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>All Shop Items | UNIBEN Alumni</title>
<link rel="icon" type="image/png" href="{{ asset('images/uniben-logo.png') }}">

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script id="tailwind-config">
tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            colors: {
              "primary": "#4A0E4E",
              "secondary": "#D4AF37",
              "surface": "#f9f9fb",
              "on-surface": "#1a1c1d",
              "on-surface-variant": "#4c4451",
              "outline": "#7d7483",
              "outline-variant": "#cec3d3",
              "surface-container-high": "#e8e8ea",
              "surface-container-lowest": "#ffffff",
              "surface-container-low": "#f3f3f5",
              "primary-container": "#4b0082",
              "on-primary-container": "#ba7ef4",
              "error": "#ba1a1a",
              "tertiary-fixed": "#ffe16d",
              "tertiary-container": "#c9a900",
              "on-tertiary-fixed": "#221b00",
            },
            fontFamily: {
              "headline": ["Manrope"],
              "body": ["Inter"],
            },
        },
    },
}
</script>
<style>
.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
:root { --bottom-nav-height: 80px; }
body { background-color: #e5e7eb; display: flex; justify-content: center; min-height: 100dvh; }
.mobile-frame { background-color: #f9f9fb; width: 100%; max-width: 420px; min-height: 100vh; position: relative; box-shadow: 0 0 40px rgba(0,0,0,0.1); overflow-x: hidden; padding-bottom: var(--bottom-nav-height); }
.top-bar { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; background: #fff; position: sticky; top: 0; z-index: 10; border-bottom: 1px solid #f3f3f5;}
.bottom-nav { position: fixed; bottom: 0; width: 100%; max-width: 420px; background: #fff; height: var(--bottom-nav-height); display: flex; justify-content: space-between; align-items: center; padding: 0 16px; box-shadow: 0 -4px 20px rgba(0,0,0,0.05); border-top-left-radius: 20px; border-top-right-radius: 20px; z-index: 100; }
.nav-item { display: flex; flex-direction: column; align-items: center; justify-content: center; color: #9ca3af; text-decoration: none; width: 60px; height: 60px; border-radius: 12px; transition: 0.2s; }
.nav-item.active { color: #fff; background: var(--primary); }
.nav-item i { font-size: 20px; margin-bottom: 6px; }
.nav-item span { font-size: 9px; font-weight: 600; }
.notification-btn { color: var(--primary); font-size: 20px; background: transparent; border: none; cursor: pointer; position: relative; }
.notification-btn::after { content: ''; position: absolute; top: 2px; right: 0px; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; border: 2px solid #fff; }
</style>
</head>
<body class="font-body text-on-surface">
<div class="mobile-frame">
<div class="top-bar">
    <div class="flex items-center gap-3">
        <a href="{{ route('shop') }}" class="text-primary"><span class="material-symbols-outlined text-2xl">arrow_back</span></a>
        <span class="font-headline font-extrabold text-[18px] text-primary">All Shop Items</span>
    </div>
    <div class="flex items-center gap-4">
        <!-- Cart -->
        <div onclick="toggleCart()" class="relative group cursor-pointer active:scale-95 duration-200" style="margin-right: 8px;">
            <span class="material-symbols-outlined text-primary">shopping_cart</span>
            <span id="cartCountBadge" class="absolute -top-1 -right-1 bg-tertiary-container text-on-tertiary-fixed text-[10px] font-bold h-4 w-4 flex items-center justify-center rounded-full shadow-lg border border-white">0</span>
        </div>
        <a href="{{ route('notifications') }}" class="relative text-primary text-xl">
            <i class="fa-solid fa-bell"></i>
            @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[8px] font-black flex items-center justify-center rounded-full border-2 border-white animation-pulse">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
            @endif
        </a>
    </div>
</div>

<main class="pt-6 pb-4 px-4 space-y-6">

    <!-- Category Filters -->
    <section class="flex gap-3 overflow-x-auto no-scrollbar pb-2" id="shopFilters">
        <button onclick="filterShop('all', this)" class="shop-filter-btn whitespace-nowrap px-6 py-2.5 rounded-full bg-primary text-on-primary font-bold text-sm">All Items</button>
        <button onclick="filterShop('apparel', this)" class="shop-filter-btn whitespace-nowrap px-6 py-2.5 rounded-full bg-surface-container-high text-on-surface-variant font-semibold text-sm hover:bg-surface-variant transition-colors">Apparel</button>
        <button onclick="filterShop('accessories', this)" class="shop-filter-btn whitespace-nowrap px-6 py-2.5 rounded-full bg-surface-container-high text-on-surface-variant font-semibold text-sm hover:bg-surface-variant transition-colors">Accessories</button>
        <button onclick="filterShop('books', this)" class="shop-filter-btn whitespace-nowrap px-6 py-2.5 rounded-full bg-surface-container-high text-on-surface-variant font-semibold text-sm hover:bg-surface-variant transition-colors">Books</button>
        <button onclick="filterShop('gifts', this)" class="shop-filter-btn whitespace-nowrap px-6 py-2.5 rounded-full bg-surface-container-high text-on-surface-variant font-semibold text-sm hover:bg-surface-variant transition-colors">Gifts</button>
    </section>

    <!-- Product Grid -->
    <section id="productGrid" class="space-y-6">
    <div class="grid grid-cols-2 gap-4">
    @foreach($products as $product)
    @php $discountedPrice = $product->price * 0.8; @endphp
    <!-- Item -->
    <div class="shop-item bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_4px_12px_rgba(0,0,0,0.03)] border border-outline-variant/20 hover:shadow-md transition-all duration-300" data-category="{{ strtolower($product->category) }}">
        <div class="aspect-square overflow-hidden bg-surface-container-low relative cursor-pointer group">
            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $product->title }}" src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80' }}"/>
            <button class="absolute top-2 right-2 h-7 w-7 rounded-full bg-white/90 shadow-sm flex items-center justify-center text-primary active:scale-95 transition-transform"><span class="material-symbols-outlined text-[13px]">favorite</span></button>
            @if($product->badge)
            <span class="absolute top-2 left-2 bg-secondary text-white text-[9px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wider">{{ $product->badge }}</span>
            @endif
            <span class="absolute bottom-2 left-2 bg-error text-white text-[9px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wider shadow-sm">-20%</span>
        </div>
        <div class="p-3 space-y-1.5">
            <h5 class="text-[13px] font-bold text-on-surface line-clamp-1 border-b border-outline-variant/20 pb-1" title="{{ $product->title }}">{{ $product->title }}</h5>
            <div class="flex items-center gap-2 pt-1">
                <span class="text-[10px] text-outline font-medium line-through">₦{{ number_format($product->price, 0) }}</span>
                <span class="text-primary font-bold text-sm">₦{{ number_format($discountedPrice, 0) }}</span>
            </div>
            <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->title) }}', {{ $discountedPrice }}, '{{ $product->image_url ?? 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80' }}')" class="w-full mt-2 py-2 bg-primary/10 text-primary rounded border border-primary/20 text-xs font-bold hover:bg-primary hover:text-white active:scale-95 transition-all text-center flex justify-center items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[14px]">shopping_cart_checkout</span> Add
            </button>
        </div>
    </div>
    @endforeach
    </div>
    </section>
</main>

<!-- Cart Sidebar Modal -->
<div id="cartModal" class="fixed inset-0 bg-black/50 z-[200] hidden transition-opacity">
    <div class="absolute top-0 right-0 max-w-sm w-full h-full bg-surface-container-lowest shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col" id="cartModalContent">
        <div class="p-5 flex items-center justify-between border-b border-surface-variant shrink-0">
            <h3 class="text-xl font-headline font-extrabold text-primary flex items-center gap-2">
                <span class="material-symbols-outlined">shopping_bag</span> Your Checkout
            </h3>
            <button onclick="toggleCart()" class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:bg-surface-variant">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
        
        <div id="cartItemsContainer" class="p-5 flex-1 overflow-y-auto space-y-3">
            <!-- Items -> JS -->
        </div>
        
        <div class="p-5 bg-surface-container-lowest border-t border-surface-variant space-y-4 shadow-[0_-10px_30px_rgba(0,0,0,0.05)] shrink-0">
            <div class="space-y-2">
                <label class="block text-sm font-bold text-primary">Delivery Method</label>
                <select id="deliverySelect" onchange="toggleAddressField()" class="w-full bg-surface-container-low border border-outline-variant rounded-lg p-2.5 text-sm outline-none focus:border-primary">
                    <option value="meeting">Pick up at Next Meeting</option>
                    <option value="home">Home Delivery Gateway</option>
                </select>
            </div>
            <div id="addressField" class="hidden space-y-2 min-h-[70px]">
                <label class="block text-xs font-bold text-on-surface-variant">Delivery Address</label>
                <textarea id="deliveryAddress" rows="2" class="w-full bg-surface-container-low border border-outline-variant rounded-lg p-2.5 text-sm resize-none outline-none focus:border-primary shadow-inner" placeholder="Enter full address..."></textarea>
            </div>
            <div class="flex items-center justify-between text-lg font-bold">
                <span class="text-on-surface-variant">Total:</span>
                <span id="cartTotalPrice" class="text-primary text-xl tracking-tight">₦0.00</span>
            </div>
            <button id="checkoutBtn" onclick="initiateCheckout()" class="w-full bg-primary text-white py-3.5 rounded-xl font-bold shadow-lg hover:bg-primary-container active:scale-[0.98] transition-all disabled:opacity-50 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">security</span> SECURE CHECKOUT
            </button>
        </div>
    </div>
</div>

    @include('layouts.bottom-nav')

</div>

<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
function filterShop(category, btnElement) {
    document.querySelectorAll('.shop-filter-btn').forEach(btn => {
        btn.classList.remove('bg-primary', 'text-on-primary', 'font-bold');
        btn.classList.add('bg-surface-container-high', 'text-on-surface-variant', 'font-semibold');
    });
    btnElement.classList.add('bg-primary', 'text-on-primary', 'font-bold');
    btnElement.classList.remove('bg-surface-container-high', 'text-on-surface-variant', 'font-semibold');
    
    document.querySelectorAll('.shop-item').forEach(item => {
        if(category === 'all' || item.dataset.category === category) {
            item.style.display = 'block';
            item.style.opacity = '0';
            item.style.transform = 'translateY(10px)';
            setTimeout(() => {
                item.style.transition = 'all 0.3s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 50);
        } else {
            item.style.display = 'none';
        }
    });
}

let cart = [];
function updateCartUI() {
    document.getElementById('cartCountBadge').innerText = cart.length;
    const container = document.getElementById('cartItemsContainer');
    const checkoutBtn = document.getElementById('checkoutBtn');
    container.innerHTML = '';
    
    let total = 0;
    if (cart.length === 0) {
        container.innerHTML = '<div class="h-full mt-12 flex flex-col items-center justify-center opacity-40"><span class="material-symbols-outlined text-6xl mb-3">remove_shopping_cart</span><p class="font-bold text-sm">Your cart is empty.</p></div>';
        checkoutBtn.disabled = true;
    } else {
        checkoutBtn.disabled = false;
        cart.forEach((item, index) => {
            total += item.price;
            container.innerHTML += `
                <div class="flex items-center gap-3 bg-white border border-surface-variant p-2 rounded-xl shadow-sm">
                    <img src="${item.img}" class="w-14 h-14 object-cover rounded-lg bg-surface-container-low shrink-0">
                    <div class="flex-1 overflow-hidden">
                        <h5 class="text-[11px] font-bold truncate leading-tight">${item.title}</h5>
                        <p class="text-primary font-bold text-[13px] mt-1">₦${item.price.toLocaleString()}</p>
                    </div>
                    <button onclick="removeFromCart(${index})" class="h-8 w-8 flex items-center justify-center text-error hover:bg-error/10 rounded-full transition-colors shrink-0"><span class="material-symbols-outlined text-[16px]">delete</span></button>
                </div>
            `;
        });
    }
    document.getElementById('cartTotalPrice').innerText = `₦${total.toLocaleString()}`;
}

function addToCart(id, title, price, img) {
    cart.push({ id, title, price, img });
    updateCartUI();
    const badge = document.getElementById('cartCountBadge');
    badge.classList.add('scale-150');
    setTimeout(() => badge.classList.remove('scale-150'), 200);
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCartUI();
}

function toggleCart() {
    const modal = document.getElementById('cartModal');
    const content = document.getElementById('cartModalContent');
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        setTimeout(() => content.classList.remove('translate-x-full'), 10);
    } else {
        content.classList.add('translate-x-full');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }
}

function toggleAddressField() {
    if (document.getElementById('deliverySelect').value === 'home') {
        document.getElementById('addressField').classList.remove('hidden');
    } else {
        document.getElementById('addressField').classList.add('hidden');
    }
}

function initiateCheckout() {
    if (cart.length === 0) return;
    const deliveryType = document.getElementById('deliverySelect').value;
    const address = document.getElementById('deliveryAddress').value;
    if(deliveryType === 'home' && !address.trim()) {
        alert('Please enter your delivery address for home delivery.');
        return;
    }
    const totalAmount = cart.reduce((sum, item) => sum + item.price, 0);
    const ref = "SHP_ALL_" + Math.floor((Math.random() * 1000000000) + 1);
    const itemNames = cart.map(i => i.title).join(', ');

    FlutterwaveCheckout({
        public_key: "{{ config('services.flutterwave.public_key') }}",
        tx_ref: ref,
        amount: totalAmount,
        currency: "NGN",
        payment_options: "card, banktransfer, ussd",
        customer: {
            email: "{{ auth()->user()->email ?? 'guest@example.com' }}",
            name: "{{ auth()->user()->name ?? 'Alumni' }}",
        },
        customizations: {
            title: "UNIBEN Shop Checkout",
            description: "Purchase of " + cart.length + " item(s)",
        },
        callback: function (data) {
            fetch('{{ route('shop.checkout') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    amount: totalAmount,
                    reference: data.transaction_id || data.tx_ref || ref,
                    items: itemNames,
                    delivery_type: deliveryType,
                    address: address
                })
            }).then(res => res.json()).then(res => {
                cart = [];
                updateCartUI();
                toggleCart();
                alert('Order processed successfully! Thanks for supporting UNIBEN Alumni.');
            });
        },
        onclose: function() { console.log("Checkout closed") }
    });
}
updateCartUI();
</script>
</body>
</html>
