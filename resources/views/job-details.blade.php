<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} | UNIBEN Alumni Lagos</title>
    <link rel="icon" type="image/png" href="{{ asset('images/uniben-logo.png') }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script id="tailwind-config">
          tailwind.config = {
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
        }
        body { background-color: #f3f4f6; font-family: 'Inter', sans-serif; }
        .main-card { border-radius: 40px; }
        .sidebar-item { border-radius: 20px; }
    </style>
</head>
<body class="font-body text-gray-800">

<div class="min-h-screen flex flex-col">
    <!-- Top Bar -->
    <header class="bg-white border-b border-gray-100 py-4 px-6 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('jobs') }}" class="text-primary hover:translate-x-[-5px] transition-transform">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <span class="font-bold text-primary text-sm uppercase tracking-widest">Opportunity Details</span>
            </div>
            <img src="{{ asset('images/uniben-logo.png') }}" class="w-8 h-8 rounded-full bg-black p-0.5 object-contain">
        </div>
    </header>

    <main class="flex-1 py-10 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="grid lg:grid-cols-3 gap-10">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white main-card p-8 md:p-12 shadow-sm border border-gray-50 overflow-hidden relative">
                        <!-- Background Accents -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -mr-10 -mt-10"></div>
                        
                        <div class="flex flex-col md:flex-row gap-8 items-start mb-10">
                            <div class="w-24 h-24 rounded-3xl bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100 overflow-hidden shadow-inner">
                                @if($job->logo_url)
                                    <img src="{{ $job->logo_url }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-primary font-black text-3xl italic">{{ substr($job->company, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <h1 class="text-3xl md:text-4xl font-black text-primary mb-3 font-headline leading-tight">{{ $job->title }}</h1>
                                <div class="flex flex-wrap gap-3 items-center">
                                    <span class="text-secondary font-extrabold uppercase tracking-widest text-sm">{{ $job->company }}</span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-200"></span>
                                    <span class="bg-primary/5 text-primary text-[10px] font-black px-4 py-1 rounded-full uppercase tracking-widest border border-primary/10">
                                        {{ $job->environment }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-12 p-8 bg-gray-50 rounded-[32px] border border-gray-100/50">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Location</p>
                                <p class="font-bold text-sm text-gray-800"><i class="fa-solid fa-location-dot text-primary/40 mr-2"></i>{{ $job->location ?? 'Nigeria' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Compensation</p>
                                <p class="font-bold text-sm text-gray-800"><i class="fa-solid fa-money-bill-wave text-primary/40 mr-2"></i>{{ $job->salary_range ?? 'Not specified' }}</p>
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Deadline</p>
                                <p class="font-bold text-sm text-gray-800"><i class="fa-solid fa-calendar-xmark text-primary/40 mr-2"></i>{{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('M d, Y') : 'Ongoing' }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-black text-primary mb-6 flex items-center gap-3">
                                <span class="w-8 h-1 bg-secondary rounded-full"></span>
                                Job Description
                            </h3>
                            <div class="text-gray-600 leading-relaxed font-medium space-y-4">
                                {!! nl2br(e($job->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white sidebar-item p-8 shadow-sm border border-gray-50 text-center">
                        <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6">Ready to apply?</h4>
                        @if($job->link)
                            <a href="{{ $job->link }}" target="_blank" class="block w-full bg-primary text-white py-5 rounded-2xl font-black text-sm tracking-widest shadow-xl shadow-primary/20 hover:brightness-110 active:scale-95 transition-all uppercase mb-4">
                                APPLY NOW <i class="fa-solid fa-arrow-up-right-from-square ml-2 text-[10px]"></i>
                            </a>
                        @else
                            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 text-xs font-bold text-gray-400 italic">
                                Contact company directly for application details.
                            </div>
                        @endif
                        <p class="text-[10px] text-gray-400 font-medium">Please mention you found this on UNIBEN Alumni portal.</p>
                    </div>

                    <div class="bg-[var(--secondary)] sidebar-item p-8 text-white relative overflow-hidden group">
                        <div class="relative z-10">
                            <h4 class="text-xl font-black mb-2 font-headline">Safety Warning</h4>
                            <p class="text-white/80 text-xs font-medium leading-relaxed">Never pay money to any employer for job applications or processing. Protect your data.</p>
                        </div>
                        <i class="fa-solid fa-shield-halved absolute -bottom-4 -right-4 text-white/10 text-8xl group-hover:scale-110 transition-transform"></i>
                    </div>

                    <div class="p-6 border border-gray-200 border-dashed rounded-[32px] text-center">
                        <p class="text-xs font-bold text-gray-400 mb-4">Share this opportunity</p>
                        <div class="flex justify-center gap-4">
                            <button class="w-10 h-10 rounded-full bg-white border border-gray-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"><i class="fa-brands fa-linkedin-in"></i></button>
                            <button class="w-10 h-10 rounded-full bg-white border border-gray-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"><i class="fa-brands fa-whatsapp"></i></button>
                            <button class="w-10 h-10 rounded-full bg-white border border-gray-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"><i class="fa-solid fa-link"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-100 py-8 px-6 mt-auto">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-[4px]">© {{ date('Y') }} UNIBEN Alumni Lagos Branch</p>
        </div>
    </footer>
</div>

</body>
</html>
