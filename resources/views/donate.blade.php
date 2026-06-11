<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support a Cause | UNIBEN Alumni Lagos</title>
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

        .form-input {
            width: 100%;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            transition: all 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(74, 14, 78, 0.05);
        }
    </style>
</head>
<body class="font-body">

<div class="layout-wrapper">
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="flex items-center gap-3">
            <a href="javascript:history.back()" class="lg:hidden text-primary"><i class="fa-solid fa-arrow-left"></i></a>
            <img src="{{ asset('images/uniben-logo.png') }}" class="w-9 h-9 rounded-full bg-black p-0.5 object-contain">
            <span class="text-primary font-bold">Donate</span>
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
        <div class="max-w-6xl mx-auto">
            <!-- Hero -->
            <section class="bg-primary p-8 md:p-12 rounded-[32px] text-white flex flex-col md:flex-row items-center gap-10 shadow-xl mb-12 relative overflow-hidden">
                <div class="flex-1 relative z-10">
                    <h2 class="text-3xl md:text-5xl font-black mb-4 tracking-tight">Invest in the Future</h2>
                    <p class="text-white/70 text-sm md:text-base leading-relaxed max-w-xl">Every donation supports scholarships, facility improvements, and alumni programs that benefit the next generation of UNIBEN graduates.</p>
                </div>
                <div class="w-32 h-32 md:w-48 md:h-48 rounded-full bg-white/10 flex items-center justify-center text-4xl md:text-6xl text-secondary relative z-10">
                     <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <!-- Background marks -->
                <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
            </section>

            <div class="grid lg:grid-cols-3 gap-10">
                <!-- Causes Column -->
                <div class="lg:col-span-2 space-y-8">
                    <h3 class="text-xl font-bold text-primary">Select a Project</h3>
                    <div class="grid md:grid-cols-1 gap-4">
                        @forelse($projects as $index => $project)
                        <label class="block relative group cursor-pointer">
                            <input type="radio" name="project" value="{{ $project->title }}" class="hidden peer" {{ $index == 0 ? 'checked' : '' }}>
                            <div class="p-8 rounded-[32px] bg-white border-2 border-transparent peer-checked:border-secondary shadow-sm transition-all group-hover:shadow-md">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="w-12 h-12 rounded-2xl bg-secondary/10 flex items-center justify-center text-secondary text-xl"><i class="fa-solid {{ $project->icon }}"></i></div>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-secondary">{{ $project->raised_amount >= $project->goal_amount ? 'FULLY FUNDED' : 'ACTIVE CAUSE' }}</span>
                                </div>
                                <h4 class="text-lg font-black text-gray-800 mb-2">{{ $project->title }}</h4>
                                <p class="text-xs text-gray-500 mb-6 leading-relaxed">{{ $project->description }}</p>
                                <div class="space-y-2">
                                    @php $percent = $project->goal_amount > 0 ? round(($project->raised_amount / $project->goal_amount) * 100) : 0; @endphp
                                    <div class="flex justify-between text-[10px] font-black text-gray-400">
                                        <span>{{ $percent }}% FUNDED</span>
                                        <span>₦{{ number_format($project->raised_amount) }} REACHED</span>
                                    </div>
                                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-secondary h-full transition-all duration-1000" style="width: {{ min(100, $percent) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @empty
                        <div class="p-12 text-center bg-white rounded-[32px] border-2 border-dashed border-gray-100">
                             <i class="fa-solid fa-heart-pulse text-4xl text-gray-200 mb-4"></i>
                             <p class="text-gray-400 font-bold">No active projects at the moment.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Checkout Column -->
                <div class="space-y-8">
                     <h3 class="text-xl font-bold text-primary">Contribution</h3>
                     <div class="bg-white p-8 rounded-[32px] shadow-lg border border-gray-50 flex flex-col gap-6">
                         <div>
                             <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4 block">Amount to Donate</label>
                             <div class="grid grid-cols-2 gap-2 mb-4">
                                 <button onclick="document.getElementById('customAmt').value='10000'" class="p-3 rounded-2xl border border-gray-100 text-xs font-black text-gray-600 hover:bg-primary hover:text-white transition-all">₦10,000</button>
                                 <button onclick="document.getElementById('customAmt').value='25000'" class="p-3 rounded-2xl border border-gray-100 text-xs font-black text-gray-600 hover:bg-primary hover:text-white transition-all">₦25,000</button>
                                 <button onclick="document.getElementById('customAmt').value='50000'" class="p-3 rounded-2xl border border-gray-100 text-xs font-black text-gray-600 hover:bg-primary hover:text-white transition-all">₦50,000</button>
                                 <button onclick="document.getElementById('customAmt').value='100000'" class="p-3 rounded-2xl border border-gray-100 text-xs font-black text-gray-600 hover:bg-primary hover:text-white transition-all">₦100,000</button>
                             </div>
                             <div class="relative">
                                 <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-gray-300">₦</span>
                                 <input id="customAmt" type="number" value="10000" class="form-input pl-12 text-lg font-black" placeholder="Custom Amount">
                             </div>
                         </div>

                         <div class="pt-4">
                             <button onclick="payDonation()" class="w-full bg-secondary text-white py-4 rounded-[24px] font-black text-sm tracking-widest shadow-xl shadow-secondary/20 hover:brightness-110 active:scale-95 transition-all flex items-center justify-center gap-3">
                                 <i class="fa-solid fa-shield-heart"></i> COMPLETE DONATION
                             </button>
                         </div>
                         <p class="text-[9px] text-center text-gray-300 font-bold leading-relaxed px-4">Secure transaction powered by Flutterwave. You will receive an official receipt via email.</p>
                     </div>

                     <!-- Recent Donors Sidebar -->
                     <div class="p-8 bg-gray-50 rounded-[32px] border border-gray-100">
                         <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Recent Benefactors</h4>
                         <div class="space-y-4">
                            @forelse($recentDonors as $donor)
                            <div class="flex items-center gap-3">
                                <img src="{{ $donor->user->avatar_url ? url($donor->user->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($donor->user->name).'&background=4A0E4E&color=fff' }}" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="text-[10px] font-black text-gray-800">{{ $donor->user->name }}</p>
                                    <p class="text-[8px] font-bold text-gray-400 uppercase">DONATED ₦{{ number_format($donor->amount) }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="py-4 text-center">
                                <p class="text-[10px] font-bold text-gray-400">Be the first to donate!</p>
                            </div>
                            @endforelse
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
  function payDonation() {
    const amount = document.getElementById('customAmt').value;
    const projectRadio = document.querySelector('input[name="project"]:checked');
    if (!projectRadio) {
        alert('Please select a project to support.');
        return;
    }
    const project = projectRadio.value;
    
    FlutterwaveCheckout({
      public_key: "{{ config('services.flutterwave.public_key') }}",
      tx_ref: "DONATION_" + Date.now(),
      amount: amount,
      currency: "NGN",
      customer: { email: "{{ auth()->user()->email }}", name: "{{ auth()->user()->name }}" },
      callback: function (data) {
        fetch('{{ route('payment.record') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ 
                amount: amount, 
                reference: data.transaction_id || data.tx_ref, 
                description: 'Donation: ' + project
            })
        }).then(() => {
            alert("Thank you for your generous donation to " + project + "!");
            window.location.reload();
        });
      }
    });
  }
</script>
</body>
</html>
