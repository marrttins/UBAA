@extends('layouts.app')

@section('content')
<div class="auth-card">
    <div class="mobile-branding">
        <img src="{{ asset('images/uniben-logo.png') }}" alt="Logo" class="logo-img">
        <div class="app-title">UNIBEN Alumni Lagos</div>
    </div>

    <h1>Welcome Back</h1>
    <p class="subtitle">Secure access to your branch account.</p>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Email or Matric Number</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-user-graduate"></i>
                <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@alumni.edu or MATRIC">
            </div>
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="form-label-row">
                <label for="password">Password</label>
                <a href="{{ route('forgot.password') }}" style="font-size: 12px; color: var(--primary); font-weight: 700; text-decoration: none;">Forgot?</a>
            </div>
            <div class="input-wrapper">
                <i class="fa-solid fa-shield-halved"></i>
                <input type="password" id="password" name="password" required placeholder="••••••••">
                <i class="fa-solid fa-eye toggle-pw" id="icon-password" onclick="togglePassword('password')"></i>
            </div>
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="checkbox-group">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Keep me signed in</label>
        </div>

        <button type="submit" class="btn-submit">
            Sign In <i class="fa-solid fa-circle-arrow-right"></i>
        </button>
    </form>

    <div class="auth-alt">
        <p class="alt-text">New to the Lagos Branch?</p>
        <a href="{{ route('signup') }}">
            <button class="btn-alt">Request Access / Join</button>
        </a>
    </div>
</div>
@endsection
