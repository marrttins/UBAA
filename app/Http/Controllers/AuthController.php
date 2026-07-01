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
            return back()->withInput()->withErrors(['email' => 'We encountered an error while sending the verification code. Please check that your email address is correct and try again.']);
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

        return redirect()->route('profile.edit')->with('success', 'Registration successful! Please update your profile record.');
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
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'We could not find an account with that email address.',
        ]);

        $user = User::where('email', $validated['email'])->first();
        $otp = (string) rand(100000, 999999);

        session([
            'password_reset_email' => $user->email,
            'password_reset_otp' => $otp,
            'password_reset_otp_expires_at' => now()->addMinutes(15),
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(
                new \App\Mail\ForgotPasswordOtpMail($user->first_name ?? $user->name, $otp, 15)
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Forgot password OTP email failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['email' => 'We encountered an error while sending the verification code. Please try again.']);
        }

        return redirect()->route('forgot.password.verify')->with('success', 'A verification code has been sent to your email.');
    }

    public function showForgotPasswordVerify()
    {
        if (!session()->has('password_reset_email')) {
            return redirect()->route('forgot.password');
        }

        return view('auth.forgot-password-verify');
    }

    public function forgotPasswordVerify(Request $request)
    {
        if (!session()->has('password_reset_email')) {
            return redirect()->route('forgot.password');
        }

        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $sessionOtp = session('password_reset_otp');
        $expiresAt = session('password_reset_otp_expires_at');
        $email = session('password_reset_email');

        if (!$sessionOtp || !$expiresAt || now()->greaterThan($expiresAt)) {
            return back()->with('error', 'The verification code has expired. Please request a new one.');
        }

        if ($request->otp !== $sessionOtp) {
            return back()->withErrors(['otp' => 'The entered verification code is incorrect.']);
        }

        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            session()->forget(['password_reset_email', 'password_reset_otp', 'password_reset_otp_expires_at']);

            Auth::login($user);

            return redirect()->intended('/dashboard')->with('success', 'Password reset successfully!');
        }

        return redirect()->route('login')->with('error', 'Something went wrong. Please try again.');
    }

    public function resendForgotPasswordOtp(Request $request)
    {
        if (!session()->has('password_reset_email')) {
            return redirect()->route('forgot.password');
        }

        $email = session('password_reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('forgot.password');
        }

        $otp = (string) rand(100000, 999999);

        session([
            'password_reset_otp' => $otp,
            'password_reset_otp_expires_at' => now()->addMinutes(15),
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($email)->send(
                new \App\Mail\ForgotPasswordOtpMail($user->first_name ?? $user->name, $otp, 15)
            );
            return back()->with('success', 'A new verification code has been sent to your email.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Resend Forgot Password OTP email failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to send verification email. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
