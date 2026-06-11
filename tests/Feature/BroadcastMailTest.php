<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\EmailBroadcast;
use App\Mail\BroadcastMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BroadcastMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_send_broadcast_to_all_users()
    {
        Mail::fake();

        // Create Admin sender
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Create some normal users
        $users = User::factory()->count(3)->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.broadcasts.send'), [
            'subject' => 'Test Broadcast Subject',
            'message' => 'This is a test broadcast message content.',
            'recipient_type' => 'all',
        ]);

        // Assert redirect back to broadcasts index
        $response->assertRedirect(route('admin.broadcasts'));
        $response->assertSessionHas('success');

        // Assert email broadcast record is created
        $this->assertDatabaseHas('email_broadcasts', [
            'subject' => 'Test Broadcast Subject',
            'message' => 'This is a test broadcast message content.',
            'recipient_type' => 'all',
            'total_sent' => 4, // 3 users + 1 admin (User::all() returns all users in db)
            'sent_by' => $admin->id,
        ]);

        // Assert emails were sent to all users
        Mail::assertSent(BroadcastMail::class, function ($mail) {
            return $mail->broadcastSubject === 'Test Broadcast Subject' &&
                   $mail->broadcastMessage === 'This is a test broadcast message content.';
        });

        // Check if correct number of emails were sent
        Mail::assertSent(BroadcastMail::class, 4);
    }

    public function test_admin_can_send_broadcast_to_selected_users()
    {
        Mail::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $users = User::factory()->count(5)->create([
            'role' => 'user',
        ]);

        $selectedUserIds = [$users[0]->id, $users[2]->id];

        $response = $this->actingAs($admin)->post(route('admin.broadcasts.send'), [
            'subject' => 'Selected Users Subject',
            'message' => 'Message to selected users.',
            'recipient_type' => 'selected',
            'recipient_ids' => $selectedUserIds,
        ]);

        $response->assertRedirect(route('admin.broadcasts'));
        $response->assertSessionHas('success');

        // Assert database entry created
        $this->assertDatabaseHas('email_broadcasts', [
            'subject' => 'Selected Users Subject',
            'message' => 'Message to selected users.',
            'recipient_type' => 'selected',
            'total_sent' => 2,
            'sent_by' => $admin->id,
        ]);

        // Assert emails sent to selected users only
        Mail::assertSent(BroadcastMail::class, 2);
        Mail::assertSent(BroadcastMail::class, function ($mail) use ($users) {
            return $mail->hasTo($users[0]->email) || $mail->hasTo($users[2]->email);
        });
        Mail::assertNotSent(BroadcastMail::class, function ($mail) use ($users) {
            return $mail->hasTo($users[1]->email);
        });
    }

    public function test_non_admin_cannot_send_broadcast()
    {
        $nonAdmin = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($nonAdmin)->post(route('admin.broadcasts.send'), [
            'subject' => 'Unauthorized Broadcast',
            'message' => 'Should fail.',
            'recipient_type' => 'all',
        ]);

        $response->assertRedirect('/');
    }
}
