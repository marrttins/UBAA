@extends('layouts.app')

@section('content')
<div class="auth-card">
    <div class="mobile-branding">
        <img src="{{ asset('images/uniben-logo.png') }}" alt="Logo" class="logo-img">
        <div class="app-title">UNIBEN Alumni Lagos</div>
    </div>

    <h1>Admin Access</h1>
    <p class="subtitle">Secure access to the UBAA admin panel.</p>

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Admin Email</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-user-shield"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@ubaa.com">
            </div>
            @error('email')
                <div class="error-text" style="color:red; font-size:12px; margin-top:5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="form-label-row">
                <label for="password">Password</label>
            </div>
            <div class="input-wrapper">
                <i class="fa-solid fa-shield-halved"></i>
                <input type="password" id="password" name="password" required placeholder="••••••••">
                <i class="fa-solid fa-eye toggle-pw" id="icon-password" onclick="togglePassword('password')"></i>
            </div>
            @error('password')
                <div class="error-text" style="color:red; font-size:12px; margin-top:5px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit" style="margin-top: 15px;">
            Sign In to Admin <i class="fa-solid fa-circle-arrow-right"></i>
        </button>
    </form>

    <div class="auth-alt" style="margin-top: 20px;">
        <p class="alt-text">Not an admin?</p>
        <a href="{{ route('login') }}">
            <button class="btn-alt">Return to User Login</button>
        </a>
    </div>
</div>
@endsection
