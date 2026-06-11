@extends('layouts.app')

@section('content')
<div class="auth-card" style="max-width: 450px;">
    <div class="mobile-branding">
        <img src="{{ asset('images/uniben-logo.png') }}" alt="Logo" class="logo-img">
        <div class="app-title">UNIBEN Alumni Lagos</div>
    </div>

    <h1>Verify Your Email</h1>
    <p class="subtitle" style="margin-bottom: 24px;">We sent a 6-digit verification code to <strong>{{ session('signup_data.email') }}</strong>. Please enter the code below to complete your registration.</p>

    @if(session('success'))
        <div style="background-color: #ecfdf5; color: #065f46; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; font-weight: 600; margin-bottom: 20px; border-left: 4px solid #34d399;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; font-weight: 600; margin-bottom: 20px; border-left: 4px solid #f87171;">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('signup.verify.post') }}">
        @csrf

        <div class="form-group" style="margin-bottom: 24px;">
            <label for="otp">Verification Code</label>
            <div class="input-wrapper" style="margin-top: 8px;">
                <i class="fa-solid fa-key"></i>
                <input type="text" id="otp" name="otp" required maxlength="6" autofocus placeholder="123456" style="letter-spacing: 4px; font-weight: 700; text-align: center; padding-left: 16px;">
            </div>
            @error('otp')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">
            Confirm & Create Account <i class="fa-solid fa-circle-check"></i>
        </button>
    </form>

    <div class="auth-alt" style="margin-top: 24px; padding-top: 16px;">
        <form method="POST" action="{{ route('signup.resend_otp') }}" style="display: inline;">
            @csrf
            <p class="alt-text" style="margin-bottom: 12px;">Didn't receive the code?</p>
            <button type="submit" class="btn-alt" style="border-color: #6b7280; color: #374151;">
                Resend Code <i class="fa-solid fa-rotate-right" style="margin-left: 4px;"></i>
            </button>
        </form>
    </div>
</div>
@endsection
