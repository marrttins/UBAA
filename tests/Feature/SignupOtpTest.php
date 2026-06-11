<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupOtpMail;
use Tests\TestCase;

class SignupOtpTest extends TestCase
{
    use RefreshDatabase;

    public function test_signup_redirects_to_otp_verification()
    {
        Mail::fake();

        $response = $this->post(route('signup.post'), [
            'title' => 'Dr',
            'first_name' => 'John',
            'middle_name' => 'Osas',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'date_of_birth' => '1990-01-01',
            'password' => 'Password123#',
            'password_confirmation' => 'Password123#',
        ]);

        $response->assertRedirect(route('signup.verify'));
        
        $this->assertTrue(session()->has('signup_data'));
        $this->assertTrue(session()->has('signup_otp'));
        $this->assertTrue(session()->has('signup_otp_expires_at'));

        $this->assertEquals('johndoe@example.com', session('signup_data.email'));

        Mail::assertSent(SignupOtpMail::class, function ($mail) {
            return $mail->hasTo('johndoe@example.com') && !empty($mail->otp);
        });
    }

    public function test_cannot_access_verify_without_signup_data()
    {
        $response = $this->get(route('signup.verify'));
        $response->assertRedirect(route('signup'));
    }

    public function test_verify_with_correct_otp_creates_user()
    {
        Mail::fake();

        // Simulate signup step
        $this->post(route('signup.post'), [
            'title' => 'Dr',
            'first_name' => 'John',
            'middle_name' => 'Osas',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'date_of_birth' => '1990-01-01',
            'password' => 'Password123#',
            'password_confirmation' => 'Password123#',
        ]);

        $otp = session('signup_otp');

        // Submit correct OTP
        $response = $this->post(route('signup.verify.post'), [
            'otp' => $otp,
        ]);

        $response->assertRedirect('/dashboard');
        
        // Assert user exists in database
        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com',
            'name' => 'John Osas Doe',
        ]);

        // Assert session clean
        $this->assertFalse(session()->has('signup_data'));
        $this->assertFalse(session()->has('signup_otp'));
        $this->assertFalse(session()->has('signup_otp_expires_at'));
    }

    public function test_verify_with_incorrect_otp_returns_error()
    {
        Mail::fake();

        $this->post(route('signup.post'), [
            'title' => 'Dr',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'date_of_birth' => '1990-01-01',
            'password' => 'Password123#',
            'password_confirmation' => 'Password123#',
        ]);

        $response = $this->post(route('signup.verify.post'), [
            'otp' => '000000', // incorrect code
        ]);

        $response->assertSessionHasErrors(['otp']);
        
        // User should not be created yet
        $this->assertDatabaseMissing('users', [
            'email' => 'johndoe@example.com',
        ]);
    }

    public function test_resend_otp_regenerates_code()
    {
        Mail::fake();

        $this->post(route('signup.post'), [
            'title' => 'Dr',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'date_of_birth' => '1990-01-01',
            'password' => 'Password123#',
            'password_confirmation' => 'Password123#',
        ]);

        $firstOtp = session('signup_otp');

        // Resend
        $response = $this->post(route('signup.resend_otp'));
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $secondOtp = session('signup_otp');

        // The new OTP should be generated and not empty
        $this->assertNotEmpty($secondOtp);
        
        Mail::assertSent(SignupOtpMail::class, 2); // sent twice (initial + resend)
    }
}
