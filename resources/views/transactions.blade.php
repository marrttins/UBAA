<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Ledger | UNIBEN Alumni Lagos</title>
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
            <a href="{{ route('payments') }}" class="lg:hidden text-primary"><i class="fa-solid fa-arrow-left"></i></a>
            <img src="{{ asset('images/uniben-logo.png') }}" class="w-9 h-9 rounded-full bg-black p-0.5 object-contain">
            <span class="text-primary font-bold text-sm">Finances</span>
        </div>
        <a href="{{ route('notifications') }}" class="relative text-primary text-xl">
            <i class="fa-solid fa-bell"></i>
            @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[8px] font-black flex items-center justify-center rounded-full border-2 border-white animation-pulse">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
            @endif
        </a>
    </header>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content mb-24 lg:mb-0">
        <div class="max-w-4xl mx-auto">
            <div class="mb-12">
                <h1 class="text-3xl font-black text-primary mb-2">Transaction Ledger</h1>
                <p class="text-gray-400 font-medium text-sm tracking-tight uppercase">Audit trail for all your branch interactions.</p>
            </div>

            <div class="space-y-4">
                @forelse($payments as $payment)
                <div class="bg-white p-6 rounded-[32px] border border-gray-50 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center group hover:shadow-xl transition-all gap-4">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl @if($payment->status == 'Paid') bg-green-50 text-green-600 @else bg-orange-50 text-orange-600 @endif flex items-center justify-center text-xl shrink-0 border border-gray-50">
                            <i class="fa-solid @if(str_contains(strtolower($payment->description), 'shop')) fa-bag-shopping @elseif(str_contains(strtolower($payment->description), 'dues')) fa-id-card @else fa-receipt @endif"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 leading-tight mb-1">{{ $payment->description }}</h4>
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $payment->created_at->format('M d, Y') }}</span>
                                <span class="w-1 h-1 bg-gray-200 rounded-full"></span>
                                <span class="text-[10px] font-black text-primary/40 uppercase tracking-widest break-all">{{ $payment->reference }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end gap-2 w-full md:w-auto mt-2 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-gray-50">
                        <span class="text-xl font-black text-primary">₦{{ number_format($payment->amount, 2) }}</span>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full @if($payment->status == 'Paid') bg-green-500 @else bg-orange-400 @endif"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest @if($payment->status == 'Paid') text-green-600 @else text-orange-600 @endif">{{ $payment->status }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-24 bg-white rounded-[48px] border border-dashed border-gray-200">
                    <i class="fa-solid fa-file-invoice-dollar text-5xl text-gray-100 mb-6"></i>
                    <p class="text-gray-400 font-bold">No financial records found</p>
                </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $payments->links() }}
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

</body>
</html>
