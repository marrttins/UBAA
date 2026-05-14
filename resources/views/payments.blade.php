<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments | UNIBEN Alumni Lagos</title>
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
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/uniben-logo.png') }}" class="w-9 h-9 rounded-full bg-black p-0.5 object-contain">
                <span class="text-primary font-bold">Financial Center</span>
            </a>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('notifications') }}" class="text-primary text-xl relative">
                <i class="fa-solid fa-bell"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                @endif
            </a>
        </div>
    </header>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content mb-24 lg:mb-0">
        <!-- Summary Cards -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
            <div class="lg:col-span-2 bg-gradient-to-br from-primary to-primary-light p-8 rounded-[32px] text-white relative overflow-hidden shadow-xl">
               <div class="relative z-10 h-full flex flex-col justify-between">
                   <div>
                       <span class="text-[10px] font-black uppercase tracking-widest text-white/50 mb-3 block">Membership Standing (2024)</span>
                       <h2 class="text-4xl md:text-5xl font-black mb-4">Good Standing</h2>
                       <p class="text-sm text-white/70 max-w-md">Your annual branch dues are up to date. Thank you for supporting the Lagos Branch progress.</p>
                   </div>
                   <div class="mt-12 flex items-end justify-between">
                       <div>
                           <p class="text-xs font-bold text-white/40 mb-1">Total Contribution</p>
                           <p class="text-2xl font-black">₦{{ number_format($duesPaidThisYear ?? 25000, 2) }}</p>
                       </div>
                       <i class="fa-solid fa-circle-check text-4xl text-secondary"></i>
                   </div>
               </div>
               <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
            </div>

            <div class="bg-white p-8 rounded-[32px] border border-gray-50 shadow-sm flex flex-col justify-center items-center text-center">
                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center text-secondary text-2xl mb-4"><i class="fa-solid fa-shield-halved"></i></div>
                <h4 class="font-bold text-primary mb-1">Financial Badge</h4>
                <p class="text-xs text-gray-400 font-semibold mb-6 uppercase tracking-wider">Premium Alum Status</p>
                <div class="w-full bg-gray-50 h-2 rounded-full overflow-hidden">
                    <div class="bg-secondary h-full" style="width: 100%"></div>
                </div>
            </div>
        </section>

        <!-- Payment Actions -->
        <section class="mb-12">
            <h3 class="text-xl font-bold text-primary mb-6">Make a Payment</h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <button onclick="document.getElementById('duesModal').classList.remove('hidden')" class="bg-white p-6 rounded-3xl border border-gray-50 shadow-sm hover:scale-[1.02] transition-all flex flex-col items-center">
                    <div class="w-10 h-10 bg-primary/5 rounded-xl flex items-center justify-center text-primary text-base mb-3"><i class="fa-solid fa-receipt"></i></div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-gray-400 text-center">Annual Dues</span>
                </button>
                <a href="{{ route('donate') }}" class="bg-white p-6 rounded-3xl border border-gray-50 shadow-sm hover:scale-[1.02] transition-all flex flex-col items-center">
                    <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 text-base mb-3"><i class="fa-solid fa-hand-holding-heart"></i></div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-gray-400 text-center">Project Fund</span>
                </a>
                <a href="{{ route('events') }}" class="bg-white p-6 rounded-3xl border border-gray-50 shadow-sm hover:scale-[1.02] transition-all flex flex-col items-center">
                    <div class="w-10 h-10 bg-secondary/5 rounded-xl flex items-center justify-center text-secondary text-base mb-3"><i class="fa-solid fa-ticket"></i></div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-gray-400 text-center">Event Pass</span>
                </a>
                <a href="{{ route('shop') }}" class="bg-white p-6 rounded-3xl border border-gray-50 shadow-sm hover:scale-[1.02] transition-all flex flex-col items-center">
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-green-600 text-base mb-3"><i class="fa-solid fa-cart-shopping"></i></div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-gray-400 text-center">Branch Shop</span>
                </a>
            </div>
        </section>

        <!-- History -->
        <section>
            <div class="flex justify-between items-end mb-6">
                <h3 class="text-xl font-bold text-primary">Recent Activity</h3>
                <a href="{{ route('transactions') }}" class="text-xs font-bold text-secondary uppercase">Full Ledger</a>
            </div>
            <div class="space-y-4">
                @foreach($payments as $payment)
                <div class="bg-white p-5 rounded-3xl border border-gray-50 shadow-sm flex items-center justify-between group hover:shadow-md transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-primary text-xl border border-gray-100"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">{{ $payment->description }}</h4>
                            <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-tight">{{ $payment->created_at->format('M d, Y') }} • #{{ $payment->reference }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="font-black text-gray-800">₦ {{ number_format($payment->amount, 2) }}</span>
                        <span class="text-[8px] font-black bg-primary/5 text-primary px-2 py-0.5 rounded uppercase tracking-widest">Receipt</span>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

<!-- Dues Modal (Kept for business logic) -->
<div id="duesModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-[200] flex items-center justify-center p-4">
   <div class="bg-white rounded-[32px] p-8 w-full max-w-md relative shadow-2xl">
      <button onclick="document.getElementById('duesModal').classList.add('hidden')" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded-full font-black text-gray-400"><i class="fa-solid fa-xmark"></i></button>
      <h3 class="text-2xl font-black text-primary mb-8 tracking-tight">ANNUAL DUES</h3>
      
      <div class="space-y-4">
         <button onclick="payWithFlutterwave(25000, 'Yearly Dues')" class="w-full bg-primary text-white p-6 rounded-3xl text-left hover:scale-[1.02] transition-transform shadow-lg shadow-primary/10">
            <div class="flex justify-between items-center mb-1">
                <span class="font-black">YEARLY PAYMENT</span>
                <span class="text-secondary font-black">₦25,000</span>
            </div>
            <p class="text-xs text-white/60">Full access for the calendar year</p>
         </button>

         <button onclick="payWithFlutterwave(2500, 'Monthly Dues')" class="w-full bg-white border border-gray-100 p-6 rounded-3xl text-left hover:shadow-md transition-all">
            <div class="flex justify-between items-center mb-1">
                <span class="font-black text-gray-800">MONTHLY PLAN</span>
                <span class="text-primary font-black">₦2,500</span>
            </div>
            <p class="text-xs text-gray-400">Convenient monthly subscription</p>
         </button>
      </div>
   </div>
</div>

<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
  function payWithFlutterwave(amount, paymentFor) {
    FlutterwaveCheckout({
      public_key: "FLWPUBK_TEST-SANDBOXDEMOKEY-X",
      tx_ref: "ALUM_PAY_" + Date.now(),
      amount: amount,
      currency: "NGN",
      customer: { email: "{{ auth()->user()->email }}", name: "{{ auth()->user()->name }}" },
      callback: function (data) {
        alert("Payment Successful!");
        document.getElementById('duesModal').classList.add('hidden');
      }
    });
  }
</script>
</body>
</html>
