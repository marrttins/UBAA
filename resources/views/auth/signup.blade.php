@extends('layouts.app')

@section('content')
<div class="auth-card" style="max-width: 600px;"> <!-- Slightly wider for registration -->
    <div class="mobile-branding">
        <img src="{{ asset('images/uniben-logo.png') }}" alt="Logo" class="logo-img">
        <div class="app-title">UNIBEN Alumni Lagos</div>
    </div>

    <h1>Join the Branch</h1>
    <p class="subtitle">Connect with thousands of Lagos-based alumni today.</p>

    <form method="POST" action="{{ route('signup.post') }}">
        @csrf

        <div style="display: grid; grid-template-columns: 100px 1fr; gap: 16px; margin-bottom: 24px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="title">Title</label>
                <div class="input-wrapper" style="padding-left: 0;">
                    <select id="title" name="title" required style="padding-left: 12px; font-weight: 700;">
                        <option value="Mr" {{ old('title') == 'Mr' ? 'selected' : '' }}>Mr</option>
                        <option value="Miss" {{ old('title') == 'Miss' ? 'selected' : '' }}>Miss</option>
                        <option value="Mrs" {{ old('title') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                        <option value="Dr" {{ old('title') == 'Dr' ? 'selected' : '' }}>Dr</option>
                        <option value="Prof" {{ old('title') == 'Prof' ? 'selected' : '' }}>Prof</option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label for="first_name">First Name</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="John">
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="middle_name">Middle Name (Optional)</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user" style="opacity: 0.5;"></i>
                    <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" placeholder="Osas">
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label for="last_name">Last Name (Surname)</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required placeholder="Doe">
                </div>
            </div>
        </div>


        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="name@alumni.edu">
                </div>
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-cake-candles"></i>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label for="matric_number">Matric Number</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-id-card"></i>
                    <input type="text" id="matric_number" name="matric_number" value="{{ old('matric_number') }}" placeholder="ENG1234567">
                </div>
            </div>
            <div class="form-group">
                <label for="graduation_year">Grad Year</label>
                <div class="input-wrapper" style="padding-left: 0;">
                    <select id="graduation_year" name="graduation_year" style="padding-left: 16px;">
                        <option value="" disabled selected>Year</option>
                        @for($i = date('Y'); $i >= 1970; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Security Password</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password" name="password" required placeholder="••••••••">
                <i class="fa-solid fa-eye toggle-pw" id="icon-password" onclick="togglePassword('password')"></i>
            </div>
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <input type="hidden" name="password_confirmation" id="password_confirmation">

        <button type="submit" class="btn-submit" onclick="document.getElementById('password_confirmation').value = document.getElementById('password').value;">
            Register for Access <i class="fa-solid fa-user-plus"></i>
        </button>
    </form>

    <div class="auth-alt">
        <p class="alt-text">Already have an account?</p>
        <a href="{{ route('login') }}">
            <button class="btn-alt">Sign In Instead</button>
        </a>
    </div>
</div>
@endsection
