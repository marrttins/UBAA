<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\DonationProject;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_record_a_payment()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('payment.record'), [
            'amount' => 25000,
            'reference' => 'TEST_REF_123',
            'description' => 'Yearly Dues',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'reference' => 'TEST_REF_123',
            'amount' => 25000,
            'description' => 'Yearly Dues',
            'status' => 'Paid',
        ]);
    }

    public function test_donation_payment_increments_raised_amount()
    {
        $user = User::factory()->create();
        $project = DonationProject::create([
            'title' => 'Library Expansion',
            'description' => 'Expand the library.',
            'goal_amount' => 100000,
            'raised_amount' => 1000,
            'icon' => 'fa-book',
        ]);

        $response = $this->actingAs($user)->post(route('payment.record'), [
            'amount' => 15000,
            'reference' => 'DON_REF_456',
            'description' => 'Donation: Library Expansion',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'reference' => 'DON_REF_456',
            'amount' => 15000,
            'description' => 'Donation: Library Expansion',
        ]);

        $project->refresh();
        $this->assertEquals(16000, $project->raised_amount);
    }

    public function test_paid_event_rsvp_creates_payment_record()
    {
        $user = User::factory()->create();
        $event = Event::create([
            'title' => 'Annual Gala 2026',
            'event_date' => now()->addDays(10),
            'location_name' => 'VI, Lagos',
            'fee' => 5000,
            'category' => 'Gala',
        ]);

        $response = $this->actingAs($user)->post(route('events.rsvp', $event), [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '1234567890',
            'payment_reference' => 'EVT_REF_789',
        ]);

        $response->assertRedirect(route('events.detail', $event->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('event_reservations', [
            'event_id' => $event->id,
            'user_id' => $user->id,
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'amount' => 5000,
            'status' => 'confirmed',
        ]);

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'reference' => 'EVT_REF_789',
            'description' => 'Event Ticket: Annual Gala 2026',
            'amount' => 5000,
            'status' => 'Paid',
        ]);
    }
}
