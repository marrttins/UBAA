@extends('layouts.app')

@section('content')
<div class="auth-card">
    <div class="mobile-branding">
        <img src="{{ asset('images/uniben-logo.png') }}" alt="Logo" class="logo-img">
        <div class="app-title">UNIBEN Alumni Lagos</div>
    </div>

    <h1>Account Recovery</h1>
    <p class="subtitle">Enter your email to receive a password reset link.</p>

    @if (session('status'))
        <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); border-radius: 12px; padding: 16px; margin-bottom: 24px; color: #166534; font-size: 14px;">
            <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('forgot.password.post') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Registred Email</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-paper-plane"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@alumni.edu">
            </div>
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">
            Send Reset Link <i class="fa-solid fa-envelope-open-text"></i>
        </button>
    </form>

    <div class="auth-alt" style="margin-top: 40px;">
        <p class="alt-text">Back to safety?</p>
        <a href="{{ route('login') }}">
            <button class="btn-alt">Return to Login</button>
        </a>
    </div>
</div>
@endsection
