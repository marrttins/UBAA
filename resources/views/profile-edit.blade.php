<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | UNIBEN Alumni Lagos</title>
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

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9ca3af;
            margin-bottom: 8px;
            margin-left: 4px;
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
            <a href="{{ route('profile') }}" class="lg:hidden text-primary"><i class="fa-solid fa-arrow-left text-xl"></i></a>
            <img src="{{ asset('images/uniben-logo.png') }}" class="w-9 h-9 rounded-full bg-black p-0.5 object-contain">
            <span class="text-primary font-bold">Edit Profile</span>
        </div>
        <button class="text-primary text-xl"><i class="fa-solid fa-bell"></i></button>
    </header>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content mb-24 lg:mb-0">
        <div class="max-w-4xl mx-auto">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf

                @if($errors->any())
                    <div class="bg-red-50 text-red-600 p-6 rounded-[24px] border border-red-100 text-sm font-bold shadow-sm">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Avatar Section -->
                <section class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-50 flex flex-col items-center">
                    <div class="relative group">
                        <div id="imagePreview" class="w-32 h-32 rounded-[40px] bg-gray-50 bg-cover bg-center ring-4 ring-primary/5 shadow-xl transition-all duration-500 overflow-hidden" 
                             style="background-image: url('{{ auth()->user()->avatar_url ? url(auth()->user()->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=4A0E4E&color=fff&size=512' }}')">
                        </div>
                        <label class="absolute inset-0 bg-black/40 rounded-[40px] flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-all cursor-pointer backdrop-blur-[2px]">
                            <i class="fa-solid fa-camera text-white text-2xl mb-1"></i>
                            <span class="text-[8px] font-black text-white uppercase tracking-widest">Change Photo</span>
                            <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden">
                        </label>
                    </div>
                    <p class="mt-6 text-[10px] font-black text-gray-300 uppercase tracking-widest">Official Alumni Portrait</p>
                </section>

                <!-- Identity Section -->
                <section class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-50">
                    <h3 class="text-xl font-bold text-primary mb-8 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-primary/5 flex items-center justify-center text-primary text-sm font-black">01</div>
                        Identity & Names
                    </h3>
                    
                    <div class="grid md:grid-cols-4 gap-6">
                        <div class="md:col-span-1">
                            <label class="form-label">Title</label>
                            <select name="title" class="form-input font-bold">
                                <option value="Mr" {{ old('title', auth()->user()->title) == 'Mr' ? 'selected' : '' }}>Mr</option>
                                <option value="Miss" {{ old('title', auth()->user()->title) == 'Miss' ? 'selected' : '' }}>Miss</option>
                                <option value="Mrs" {{ old('title', auth()->user()->title) == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" class="form-input" required placeholder="John">
                        </div>
                        <div class="md:col-span-1">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" value="{{ old('middle_name', auth()->user()->middle_name) }}" class="form-input" placeholder="Osas">
                        </div>
                        <div class="md:col-span-1">
                            <label class="form-label">Last Name (Surname)</label>
                            <input type="text" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}" class="form-input" required placeholder="Doe">
                        </div>
                        <div class="md:col-span-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-input" required placeholder="alumni@example.com">
                        </div>
                        <div class="md:col-span-1">
                            <label class="form-label">Matric Number</label>
                            <input type="text" name="matric_number" value="{{ old('matric_number', auth()->user()->matric_number) }}" class="form-input" placeholder="ENG123..">
                        </div>
                        <div class="md:col-span-1">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-input" placeholder="080..">
                        </div>
                        <div class="md:col-span-1">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}" class="form-input">
                        </div>
                         <div class="md:col-span-3">
                            <label class="form-label">Current Location</label>
                            <input type="text" name="location" value="{{ old('location', auth()->user()->location) }}" class="form-input" placeholder="Lagos, Nigeria">
                        </div>
                    </div>
                </section>

                <!-- Professional Section -->
                <section class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-50">
                    <h3 class="text-xl font-bold text-primary mb-8 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-primary/5 flex items-center justify-center text-primary text-sm font-black">02</div>
                        Career & Bio
                    </h3>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Current Role</label>
                            <input type="text" name="job_title" value="{{ old('job_title', auth()->user()->job_title) }}" class="form-input" placeholder="Senior Architect">
                        </div>
                        <div>
                            <label class="form-label">Organization / Company</label>
                            <input type="text" name="company" value="{{ old('company', auth()->user()->company) }}" class="form-input" placeholder="Company Name">
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">Professional Summary (Bio)</label>
                            <textarea name="bio" rows="5" class="form-input resize-none" placeholder="Tell the network about your journey...">{{ old('bio', auth()->user()->bio) }}</textarea>
                        </div>
                    </div>
                </section>

                <!-- Academic Records -->
                <section class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-50">
                    <div class="flex justify-between items-center mb-10">
                        <h3 class="text-xl font-bold text-primary flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-primary/5 flex items-center justify-center text-primary text-sm font-black">03</div>
                            UNIBEN Records
                        </h3>
                        <button type="button" onclick="addDegreeRow()" class="text-[10px] font-black text-secondary border border-secondary/20 px-4 py-2 rounded-xl bg-secondary/5 hover:bg-secondary hover:text-white transition-all">+ ADD RECORD</button>
                    </div>

                    <div id="degreesContainer" class="space-y-6">
                        @php $degrees = old('degrees', auth()->user()->degrees->toArray() ?? []); @endphp
                        @forelse($degrees as $index => $deg)
                        <div class="degree-row p-6 bg-gray-50 rounded-3xl relative border border-gray-100 group animate-[fadeIn_0.3s_ease-out]">
                            <button type="button" onclick="removeDegreeRow(this)" class="absolute top-4 right-4 text-red-300 hover:text-red-500 transition-colors"><i class="fa-solid fa-circle-xmark"></i></button>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="form-label">Degree Type</label>
                                    <select name="degrees[{{ $index }}][degree_type]" class="form-input">
                                        <option value="BSc" @if(($deg['degree_type'] ?? '') == 'BSc') selected @endif>BSc</option>
                                        <option value="BA" @if(($deg['degree_type'] ?? '') == 'BA') selected @endif>BA</option>
                                        <option value="BEng" @if(($deg['degree_type'] ?? '') == 'BEng') selected @endif>BEng</option>
                                        <option value="MSc" @if(($deg['degree_type'] ?? '') == 'MSc') selected @endif>MSc</option>
                                        <option value="PhD" @if(($deg['degree_type'] ?? '') == 'PhD') selected @endif>PhD</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Grad Year</label>
                                    <input type="number" name="degrees[{{ $index }}][graduation_year]" value="{{ $deg['graduation_year'] ?? '' }}" class="form-input" placeholder="YYYY">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">Course / Major</label>
                                    <input type="text" name="degrees[{{ $index }}][course]" value="{{ $deg['course'] ?? '' }}" class="form-input" placeholder="e.g. Accounting">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">Faculty</label>
                                    <input type="text" name="degrees[{{ $index }}][department]" value="{{ $deg['department'] ?? '' }}" class="form-input" placeholder="e.g. Management Sciences">
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-gray-300 font-bold text-xs py-10 border-2 border-dashed border-gray-100 rounded-3xl">No degrees logged yet</p>
                        @endforelse
                    </div>
                </section>

                <!-- Social Presence -->
                <section class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-50">
                    <h3 class="text-xl font-bold text-primary mb-8 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-primary/5 flex items-center justify-center text-primary text-sm font-black">04</div>
                        Social Presence
                    </h3>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="relative">
                            <i class="fa-brands fa-linkedin absolute left-5 top-1/2 -translate-y-1/2 text-primary/40"></i>
                            <input type="text" name="linkedin_url" value="{{ old('linkedin_url', auth()->user()->linkedin_url) }}" class="form-input pl-12" placeholder="LinkedIn Profile URL">
                        </div>
                        <div class="relative">
                            <i class="fa-brands fa-x-twitter absolute left-5 top-1/2 -translate-y-1/2 text-primary/40"></i>
                            <input type="text" name="twitter_url" value="{{ old('twitter_url', auth()->user()->twitter_url) }}" class="form-input pl-12" placeholder="X (Twitter) URL">
                        </div>
                        <div class="relative">
                            <i class="fa-brands fa-facebook absolute left-5 top-1/2 -translate-y-1/2 text-primary/40"></i>
                            <input type="text" name="facebook_url" value="{{ old('facebook_url', auth()->user()->facebook_url) }}" class="form-input pl-12" placeholder="Facebook URL">
                        </div>
                        <div class="relative">
                            <i class="fa-brands fa-instagram absolute left-5 top-1/2 -translate-y-1/2 text-primary/40"></i>
                            <input type="text" name="instagram_url" value="{{ old('instagram_url', auth()->user()->instagram_url) }}" class="form-input pl-12" placeholder="Instagram URL">
                        </div>
                    </div>
                </section>

                <div class="pt-6 pb-12">
                    <button type="submit" class="w-full bg-primary text-white py-5 rounded-[24px] font-black text-sm tracking-widest shadow-xl shadow-primary/20 hover:brightness-110 active:scale-95 transition-all flex items-center justify-center gap-3">
                        <i class="fa-solid fa-cloud-arrow-up"></i> UPDATE ALUMNI RECORDS
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    @include('layouts.bottom-nav')
</div>

<script>
    // Image preview
    const avatarInput = document.getElementById('avatarInput');
    const imagePreview = document.getElementById('imagePreview');
    avatarInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = e => imagePreview.style.backgroundImage = `url('${e.target.result}')`;
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Degree Rows
    let degreeIndex = {{ count(old('degrees', auth()->user()->degrees ?? [])) ?: 1 }};
    function addDegreeRow() {
        const container = document.getElementById('degreesContainer');
        const emptyState = container.querySelector('p');
        if(emptyState) emptyState.remove();

        const html = `
            <div class="degree-row p-6 bg-gray-50 rounded-3xl relative border border-gray-100 group animate-[fadeIn_0.3s_ease-out] mt-6">
                <button type="button" onclick="removeDegreeRow(this)" class="absolute top-4 right-4 text-red-300 hover:text-red-500 transition-colors"><i class="fa-solid fa-circle-xmark"></i></button>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Degree Type</label>
                        <select name="degrees[${degreeIndex}][degree_type]" class="form-input">
                            <option value="BSc">BSc</option><option value="BA">BA</option><option value="BEng">BEng</option><option value="MSc">MSc</option><option value="PhD">PhD</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Grad Year</label>
                        <input type="number" name="degrees[${degreeIndex}][graduation_year]" class="form-input" placeholder="YYYY">
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Course / Major</label>
                        <input type="text" name="degrees[${degreeIndex}][course]" class="form-input" placeholder="e.g. Computer Science" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Faculty</label>
                        <input type="text" name="degrees[${degreeIndex}][department]" class="form-input" placeholder="e.g. Physical Sciences">
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        degreeIndex++;
    }

    function removeDegreeRow(btn) {
        btn.closest('.degree-row').remove();
        if(document.querySelectorAll('.degree-row').length === 0) {
            document.getElementById('degreesContainer').innerHTML = '<p class="text-center text-gray-300 font-bold text-xs py-10 border-2 border-dashed border-gray-100 rounded-3xl">No degrees logged yet</p>';
        }
    }
</script>
</body>
</html>
