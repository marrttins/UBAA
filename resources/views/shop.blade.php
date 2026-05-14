<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Shop | UNIBEN Alumni Lagos</title>
    <link rel="icon" type="image/png" href="{{ asset('images/uniben-logo.png') }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script id="tailwind-config">
          tailwind.config = {
            darkMode: "class",
            theme: {
              extend: {
                colors: {
                  "primary": "#4A0E4E",
                  "primary-dark": "#370a3a",
                  "secondary": "#D4AF37",
                  "bg-body": "#f8f9fa",
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
        :root {
            --primary: #4A0E4E;
            --secondary: #D4AF37;
            --bg-body: #f8f9fa;
            --sidebar-width: 260px;
            --bottom-nav-height: 80px;
        }

        body {
            background-color: #f3f4f6;
            color: #1a1c1d;
            font-family: 'Inter', sans-serif;
            margin: 0;
            min-height: 100vh;
        }

        .layout-wrapper {
            display: flex;
            flex-direction: column;
            width: 100%;
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid #e5e7eb;
            width: 100%;
        }

        .sidebar {
            display: none;
            width: var(--sidebar-width);
            background: #fff;
            height: calc(100vh - 73px);
            position: sticky;
            top: 73px;
            border-right: 1px solid #e5e7eb;
            padding: 24px;
            flex-direction: column;
            gap: 8px;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            height: var(--bottom-nav-height);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0 16px;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.05);
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            z-index: 100;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            text-decoration: none;
            transition: 0.2s;
            padding: 12px;
            border-radius: 12px;
        }

        .sidebar .nav-item {
            flex-direction: row;
            justify-content: flex-start;
            gap: 16px;
            width: 100%;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-item.active {
            color: #fff;
            background: var(--primary);
        }

        .nav-item i { font-size: 20px; }
        .nav-item span { font-size: 9px; font-weight: 700; }
        .sidebar .nav-item span { font-size: 14px; }

        .main-content {
            flex: 1;
            padding: 24px;
            width: 100%;
        }

        @media (min-width: 1024px) {
            .layout-wrapper { flex-direction: row; flex-wrap: wrap; }
            .sidebar { display: flex; }
            .bottom-nav { display: none; }
            .main-content { padding: 40px; }
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="font-body">

<div class="layout-wrapper">
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/uniben-logo.png') }}" class="w-9 h-9 rounded-full bg-black p-0.5 object-contain">
            <span class="text-primary font-bold">Alumni Shop</span>
        </div>
        <div class="flex items-center gap-4">
            <div onclick="toggleCart()" class="relative cursor-pointer hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-primary">shopping_bag</span>
                <span id="cartCountBadge" class="absolute -top-1 -right-1 bg-secondary text-primary text-[9px] font-black h-4 w-4 flex items-center justify-center rounded-full">0</span>
            </div>
            <button class="text-primary text-xl"><i class="fa-solid fa-bell"></i></button>
        </div>
    </header>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content mb-24 lg:mb-0">
        <!-- Promo Banner -->
        <section class="relative overflow-hidden rounded-3xl bg-primary h-[300px] md:h-[400px] flex items-center mb-12 group">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80" class="w-full h-full object-cover opacity-30 group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/60 to-transparent"></div>
            </div>
            <div class="relative z-10 p-8 md:p-16 max-w-2xl text-white">
                <span class="inline-block px-3 py-1 rounded-full bg-secondary text-primary text-[10px] font-bold tracking-widest uppercase mb-4">Limited Edition</span>
                <h2 class="text-4xl md:text-6xl font-headline font-extrabold mb-4 leading-tight">Heritage Collection 2026</h2>
                <p class="text-white/80 text-sm md:text-lg mb-8 max-w-lg">Commemorate your time at Great Benin with our premium apparel designed for the elite alumni.</p>
                <button onclick="window.scrollTo({top: document.getElementById('productGrid').offsetTop, behavior: 'smooth'})" class="bg-secondary text-primary px-8 py-3 rounded-xl font-bold hover:brightness-110 active:scale-95 transition-all">Explore Drop</button>
            </div>
        </section>

        <!-- Product Grid -->
        <section id="productGrid" class="space-y-8">
            <div class="flex justify-between items-end">
                <h3 class="text-2xl font-bold text-primary">Explore All Items</h3>
                <div class="flex gap-2 overflow-x-auto no-scrollbar">
                   <button class="bg-primary text-white px-4 py-1.5 rounded-full text-xs font-bold">All</button>
                   <button class="bg-white border text-gray-400 px-4 py-1.5 rounded-full text-xs">Apparel</button>
                   <button class="bg-white border text-gray-400 px-4 py-1.5 rounded-full text-xs">Gifts</button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-50 flex flex-col group hover:shadow-xl transition-all duration-300">
                    <div class="h-64 overflow-hidden relative bg-gray-50 flex items-center justify-center">
                        @if($product->image_url)
                            <img src="{{ asset($product->image_url) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <i class="fas fa-box-open text-4xl text-gray-200"></i>
                        @endif
                        
                        @if($product->original_price && $product->original_price > $product->price)
                            @php $discount = round((($product->original_price - $product->price) / $product->original_price) * 100); @endphp
                            <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] px-2 py-1 rounded font-bold">-{{ $discount }}%</span>
                        @endif
                        <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 space-y-3 bg-white/60 backdrop-blur-md">
                            <div class="flex gap-2">
                                @if($product->sizes)
                                    <select id="size-{{ $product->id }}" class="flex-1 bg-white border-none rounded-xl text-[10px] font-bold py-2 focus:ring-primary appearance-none">
                                        @foreach(explode(',', $product->sizes) as $size)
                                            <option value="{{ $size }}">{{ $size }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <div class="flex items-center bg-white rounded-xl border border-gray-100 overflow-hidden shrink-0">
                                    <button onclick="changeQtyUI({{ $product->id }}, -1)" class="px-2 py-1 hover:bg-gray-50 text-gray-400 font-bold">-</button>
                                    <span id="qty-val-{{ $product->id }}" class="px-2 text-xs font-black text-primary">1</span>
                                    <button onclick="changeQtyUI({{ $product->id }}, 1)" class="px-2 py-1 hover:bg-gray-50 text-gray-400 font-bold">+</button>
                                </div>
                            </div>
                            <button onclick="handleAddToCart({{ $product->id }}, '{{ addslashes($product->title) }}', {{ $product->price }}, '{{ $product->image_url ? asset($product->image_url) : '' }}', {{ $product->delivery_fee ?? 3500 }}, {{ $product->sizes ? 'true' : 'false' }})" class="w-full bg-primary text-white py-3 rounded-xl font-bold text-xs shadow-lg flex items-center justify-center gap-2 hover:brightness-110 active:scale-95 transition-all">
                                <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span> ADD TO CART
                            </button>
                        </div>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <span class="text-[10px] font-bold text-secondary uppercase mb-1">{{ $product->category }}</span>
                        <h4 class="font-bold text-gray-800 text-sm mb-4 line-clamp-2 leading-tight">{{ $product->title }}</h4>
                        <div class="mt-auto">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    @if($product->original_price)
                                        <span class="text-xs text-gray-300 line-through">₦{{ number_format($product->original_price) }}</span>
                                    @endif
                                    <span class="text-primary font-black text-base">₦{{ number_format($product->price) }}</span>
                                </div>
                                <span class="text-[9px] font-bold text-gray-400 italic">Qty: {{ $product->quantity }}</span>
                            </div>
                            @if($product->sizes)
                                <div class="flex gap-1">
                                    @foreach(explode(',', $product->sizes) as $size)
                                        <span class="text-[8px] px-1.5 py-0.5 bg-gray-50 border border-gray-100 rounded text-gray-500 font-bold uppercase">{{ substr($size, 0, 1) }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

<!-- Cart Modal -->
<div id="cartModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[200] hidden transition-opacity">
    <div id="cartModalContent" class="absolute top-0 right-0 max-w-sm w-full h-full bg-white shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col">
        <div class="p-6 border-b flex items-center justify-between">
            <h3 class="font-black text-xl text-primary uppercase tracking-tight flex items-center gap-2">
                <span class="material-symbols-outlined">shopping_bag</span> YOUR CART
            </h3>
            <button onclick="toggleCart()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <div id="cartItemsContainer" class="flex-1 p-6 overflow-y-auto space-y-4 no-scrollbar">
            <!-- Injected via JS -->
        </div>
        
        <div class="p-6 border-t bg-gray-50 space-y-4">
            <!-- Delivery Options -->
            <div class="space-y-3">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Delivery Mode</p>
                <div class="grid grid-cols-2 gap-3">
                    <button onclick="setDelivery('meeting')" id="btn-delivery-meeting" class="flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-primary bg-primary/5 text-primary transition-all">
                        <span class="material-symbols-outlined text-lg">groups</span>
                        <span class="text-[9px] font-black mt-1">AT MEETING</span>
                        <span class="text-[8px] font-bold opacity-70">FREE</span>
                    </button>
                    <button onclick="setDelivery('home')" id="btn-delivery-home" class="flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-gray-100 bg-white text-gray-400 hover:border-primary/30 transition-all">
                        <span class="material-symbols-outlined text-lg">local_shipping</span>
                        <span class="text-[9px] font-black mt-1">HOME DELIVERY</span>
                        <span class="text-[8px] font-bold opacity-70">₦3,500</span>
                    </button>
                </div>
            </div>

            <!-- Home Delivery Info (Hidden by default) -->
            <div id="deliveryInfoBlock" class="hidden space-y-3 animate-pulse-once">
                <div class="space-y-1">
                    <input type="text" id="deliveryAddress" placeholder="Full Delivery Address" class="w-full bg-white border-gray-200 rounded-xl text-xs py-3 focus:ring-primary focus:border-primary">
                </div>
                <div class="space-y-1">
                    <input type="tel" id="deliveryPhone" placeholder="Contact Phone Number" class="w-full bg-white border-gray-200 rounded-xl text-xs py-3 focus:ring-primary focus:border-primary">
                </div>
            </div>

            <div class="space-y-2 pt-2 border-t border-gray-200">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-400 font-bold uppercase">Subtotal</span>
                    <span id="cartSubtotal" class="font-black text-gray-600">₦0.00</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-400 font-bold uppercase">Delivery</span>
                    <span id="cartDeliveryFee" class="font-black text-gray-600">₦0.00</span>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <span class="font-black text-primary uppercase tracking-tighter">GRAND TOTAL</span>
                    <span id="cartTotalPrice" class="text-2xl font-black text-primary">₦0.00</span>
                </div>
            </div>

            <button onclick="initiateCheckout()" id="checkoutBtn" class="w-full bg-primary text-white py-4 rounded-xl font-black text-sm tracking-widest shadow-lg hover:brightness-110 active:scale-95 transition-all">
                SECURE CHECKOUT
            </button>
        </div>
    </div>
</div>

<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
    let cart = [];
    let deliveryMode = 'meeting'; // 'meeting' or 'home'
    const deliveryFee = 3500;

    function setDelivery(mode) {
        deliveryMode = mode;
        const btnMeeting = document.getElementById('btn-delivery-meeting');
        const btnHome = document.getElementById('btn-delivery-home');
        const infoBlock = document.getElementById('deliveryInfoBlock');

        if (mode === 'meeting') {
            btnMeeting.className = "flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-primary bg-primary/5 text-primary transition-all";
            btnHome.className = "flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-gray-100 bg-white text-gray-400 hover:border-primary/30 transition-all";
            infoBlock.classList.add('hidden');
        } else {
            btnHome.className = "flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-primary bg-primary/5 text-primary transition-all";
            btnMeeting.className = "flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-gray-100 bg-white text-gray-400 hover:border-primary/30 transition-all";
            infoBlock.classList.remove('hidden');
        }
        updateCartUI();
    }
    
    function updateCartUI() {
        document.getElementById('cartCountBadge').innerText = cart.length;
        const container = document.getElementById('cartItemsContainer');
        const checkoutBtn = document.getElementById('checkoutBtn');
        container.innerHTML = '';
        let subtotal = 0;
        let maxDelivery = 0;

        if (cart.length === 0) {
            container.innerHTML = '<div class="h-full flex flex-col items-center justify-center text-gray-300 mt-20"><i class="fa-solid fa-shopping-basket text-6xl mb-4"></i><p class="font-bold">Your cart is empty</p></div>';
            checkoutBtn.disabled = true;
        } else {
            checkoutBtn.disabled = false;
            cart.forEach((item, index) => {
                let itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                if (item.deliveryFee > maxDelivery) maxDelivery = item.deliveryFee;
                container.innerHTML += `
                    <div class="flex items-center gap-4 bg-white p-3 rounded-2xl border border-gray-100 shadow-sm">
                        <img src="${item.img || 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80'}" class="w-16 h-16 object-cover rounded-xl bg-gray-50">
                        <div class="flex-1">
                            <h5 class="text-xs font-black text-gray-800 line-clamp-1">${item.title}</h5>
                            <div class="flex items-center gap-2 mt-1">
                                <p class="text-primary font-black text-sm">₦${itemTotal.toLocaleString()}</p>
                                <span class="text-[9px] font-bold text-gray-400">×${item.quantity}</span>
                                ${item.size ? `<span class="bg-gray-100 px-1.5 py-0.5 rounded text-[8px] font-black uppercase text-gray-500">${item.size}</span>` : ''}
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <button onclick="changeCartQty(${index}, 1)" class="w-6 h-6 rounded-lg bg-gray-50 flex items-center justify-center text-xs hover:bg-primary hover:text-white transition-all">+</button>
                            <button onclick="changeCartQty(${index}, -1)" class="w-6 h-6 rounded-lg bg-gray-50 flex items-center justify-center text-xs hover:bg-red-50 hover:text-red-500 transition-all">-</button>
                        </div>
                        <button onclick="removeFromCart(${index})" class="text-gray-300 hover:text-red-500 transition-colors ml-2"><i class="fa-solid fa-trash-can text-xs"></i></button>
                    </div>
                `;
            });
        }
        
        let finalDelivery = (deliveryMode === 'home') ? maxDelivery : 0;
        let total = subtotal + finalDelivery;
        document.getElementById('cartSubtotal').innerText = `₦${subtotal.toLocaleString()}`;
        document.getElementById('cartDeliveryFee').innerText = `₦${finalDelivery.toLocaleString()}`;
        document.getElementById('cartTotalPrice').innerText = `₦${total.toLocaleString()}`;
    }
        
    function changeQtyUI(id, delta) {
        const el = document.getElementById(`qty-val-${id}`);
        let current = parseInt(el.innerText);
        current = Math.max(1, current + delta);
        el.innerText = current;
    }

    function handleAddToCart(id, title, price, img, deliveryFee, hasSizes) {
        const qty = parseInt(document.getElementById(`qty-val-${id}`).innerText);
        let size = null;
        if (hasSizes) {
            size = document.getElementById(`size-${id}`).value;
        }
        
        // Reset UI qty back to 1
        document.getElementById(`qty-val-${id}`).innerText = 1;
        
        addToCart(id, title, price, img, deliveryFee, size, qty);
    }

    function addToCart(id, title, price, img, deliveryFee, size, quantity) {
        // Check if item with same ID and size exists
        const existing = cart.find(i => i.id === id && i.size === size);
        if (existing) {
            existing.quantity += quantity;
        } else {
            cart.push({ id, title, price, img, deliveryFee, size, quantity });
        }
        updateCartUI();
        toggleCart();
    }

    function changeCartQty(index, delta) {
        cart[index].quantity += delta;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        updateCartUI();
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

    function initiateCheckout() {
        if (cart.length === 0) return;
        
        const subtotal = cart.reduce((sum, item) => sum + item.price, 0);
        const finalDelivery = (deliveryMode === 'home') ? deliveryFee : 0;
        const totalAmount = subtotal + finalDelivery;

        if (deliveryMode === 'home') {
            const addr = document.getElementById('deliveryAddress').value;
            const phone = document.getElementById('deliveryPhone').value;
            if (!addr || !phone) {
                alert('Please provide delivery address and contact phone.');
                return;
            }
        }

        const ref = "ALUM_SHP_" + Date.now();
        FlutterwaveCheckout({
            public_key: "FLWPUBK_TEST-SANDBOXDEMOKEY-X",
            tx_ref: ref,
            amount: totalAmount,
            currency: "NGN",
            customer: { email: "{{ auth()->user()->email }}", name: "{{ auth()->user()->name }}" },
            customizations: { title: "UNIBEN Alumni Shop", description: "Payment for Heritage Items" },
            callback: function(data) {
                 fetch('{{ route('shop.checkout') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ 
                        amount: totalAmount, 
                        reference: data.transaction_id, 
                        items: cart.map(i => `${i.title} (${i.size || 'No Size'}) x${i.quantity}`).join(', '),
                        delivery_mode: deliveryMode,
                        delivery_address: document.getElementById('deliveryAddress').value,
                        delivery_phone: document.getElementById('deliveryPhone').value
                    })
                }).then(() => {
                    cart = []; updateCartUI(); toggleCart();
                    alert('Order complete! Thank you for your purchase.');
                });
            }
        });
    }
</script>
</body>
</html>
