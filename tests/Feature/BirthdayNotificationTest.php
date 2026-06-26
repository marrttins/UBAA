<?php

namespace Tests\Feature;

use App\Models\User;
use App\Mail\MemberBirthdayNotificationMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class BirthdayNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_birthday_notification_sent_when_no_celebrants()
    {
        Mail::fake();

        // Create a logged in user and another member, neither having birthday today
        $authUser = User::factory()->create([
            'date_of_birth' => now()->subYears(30)->subDays(5)->format('Y-m-d'),
        ]);
        $otherUser = User::factory()->create([
            'date_of_birth' => now()->subYears(25)->subDays(10)->format('Y-m-d'),
        ]);

        $response = $this->actingAs($authUser)->get(route('directory'));

        $response->assertStatus(200);
        $response->assertViewHas('todayCelebrants', function ($celebrants) {
            return $celebrants->isEmpty();
        });

        Mail::assertNothingSent();
    }

    public function test_birthday_notification_sent_to_other_members()
    {
        Mail::fake();
        Cache::clear();

        // Create logged in user (recipient)
        $authUser = User::factory()->create([
            'date_of_birth' => now()->subYears(30)->subDays(5)->format('Y-m-d'),
        ]);

        // Create birthday celebrant today
        $celebrant = User::factory()->create([
            'name' => 'Celebrant User',
            'date_of_birth' => now()->subYears(25)->format('Y-m-d'), // matches today's month and day
        ]);

        // Create another recipient
        $anotherRecipient = User::factory()->create([
            'date_of_birth' => now()->subYears(28)->subDays(2)->format('Y-m-d'),
        ]);

        $response = $this->actingAs($authUser)->get(route('directory'));

        $response->assertStatus(200);
        $response->assertViewHas('todayCelebrants', function ($celebrants) use ($celebrant) {
            return $celebrants->contains($celebrant);
        });

        // The birthday notification should be queued to $authUser and $anotherRecipient (but NOT the celebrant themselves)
        Mail::assertQueued(MemberBirthdayNotificationMail::class, 2);
        
        Mail::assertQueued(MemberBirthdayNotificationMail::class, function ($mail) use ($authUser, $celebrant) {
            return $mail->hasTo($authUser->email) && $mail->celebrant->id === $celebrant->id;
        });

        Mail::assertQueued(MemberBirthdayNotificationMail::class, function ($mail) use ($anotherRecipient, $celebrant) {
            return $mail->hasTo($anotherRecipient->email) && $mail->celebrant->id === $celebrant->id;
        });

        Mail::assertNotQueued(MemberBirthdayNotificationMail::class, function ($mail) use ($celebrant) {
            return $mail->hasTo($celebrant->email);
        });

        // Assert that the cache key is set to prevent duplicate sending
        $currentYear = date('Y');
        $this->assertTrue(Cache::has("birthday_notification_sent_{$celebrant->id}_{$currentYear}"));

        // Visit the directory again. Mails should not be sent a second time.
        Mail::fake(); // reset fake to clear count
        $response = $this->actingAs($authUser)->get(route('directory'));
        $response->assertStatus(200);
        Mail::assertNothingQueued();
    }
}
