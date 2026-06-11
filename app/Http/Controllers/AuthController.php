<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showSignup()
    {
        return view('auth.signup');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $ipAddress = $request->ip();
            $userAgent = $request->userAgent();
            $time = now()->format('F j, Y, g:i a');

            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(
                    new \App\Mail\LoginNotificationMail($user, $ipAddress, $userAgent, $time)
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Login notification email failed: ' . $e->getMessage());
            }

            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function signup(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:10'],
            'first_name' => ['required', 'string', 'max:50'],
            'middle_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'date_of_birth' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $middleName = $validated['middle_name'] ?? '';
        $fullName = trim("{$validated['first_name']} {$middleName} {$validated['last_name']}");
        if (!empty($request->nickname)) {
            $fullName .= " ({$request->nickname})";
        }

        // Store the registration data in the session
        $registrationData = [
            'title' => $validated['title'],
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? '',
            'last_name' => $validated['last_name'],
            'name' => $fullName,
            'email' => $validated['email'],
            'date_of_birth' => $validated['date_of_birth'],
            'password' => Hash::make($validated['password']),
        ];

        session(['signup_data' => $registrationData]);

        // Generate OTP code
        $otp = (string) rand(100000, 999999);
        session([
            'signup_otp' => $otp,
            'signup_otp_expires_at' => now()->addMinutes(15),
        ]);

        // Send OTP email
        try {
            \Illuminate\Support\Facades\Mail::to($validated['email'])->send(
                new \App\Mail\SignupOtpMail($validated['first_name'], $otp, 15)
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Signup OTP email failed: ' . $e->getMessage());
        }

        return redirect()->route('signup.verify');
    }

    public function showVerifyOtp()
    {
        if (!session()->has('signup_data')) {
            return redirect()->route('signup');
        }

        return view('auth.signup-verify');
    }

    public function verifyOtp(Request $request)
    {
        if (!session()->has('signup_data')) {
            return redirect()->route('signup');
        }

        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $sessionOtp = session('signup_otp');
        $expiresAt = session('signup_otp_expires_at');

        if (!$sessionOtp || !$expiresAt || now()->greaterThan($expiresAt)) {
            return back()->with('error', 'The verification code has expired. Please request a new one.');
        }

        if ($request->otp !== $sessionOtp) {
            return back()->withErrors(['otp' => 'The entered verification code is incorrect.']);
        }

        // Create the user
        $data = session('signup_data');
        $user = User::create($data);

        // Clear session data
        session()->forget(['signup_data', 'signup_otp', 'signup_otp_expires_at']);

        // Log the user in
        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

    public function resendOtp(Request $request)
    {
        if (!session()->has('signup_data')) {
            return redirect()->route('signup');
        }

        $data = session('signup_data');
        $otp = (string) rand(100000, 999999);

        session([
            'signup_otp' => $otp,
            'signup_otp_expires_at' => now()->addMinutes(15),
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($data['email'])->send(
                new \App\Mail\SignupOtpMail($data['first_name'], $otp, 15)
            );
            return back()->with('success', 'A new verification code has been sent to your email.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Resend Signup OTP email failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to send verification email. Please try again.');
        }
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        // Conceptual mockup for typical reset logic
        $request->validate(['email' => 'required|email']);
        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
