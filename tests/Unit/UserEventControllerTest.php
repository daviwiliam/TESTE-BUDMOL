<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\User;
use App\Models\UserEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserEventControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $admin;
    private $event;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['admin' => true]);
        $this->event = Event::factory()->create(['user_id' => $this->admin->id]);
    }

    public function test_my_events()
    {
        Event::factory()->create(['user_id' => $this->admin->id]);

        $response = $this->actingAs($this->admin)
                         ->getJson("/api/my-events/{$this->admin->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['user_id' => $this->admin->id]);
    }

    public function test_participants()
    {
        $event = Event::factory()->create();
        $participant = User::factory()->create();
        $event->participants()->attach($participant->id);

        $response = $this->actingAs($this->admin)
                         ->getJson("/api/participants/{$event->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $participant->id]);
    }

    public function test_subscriptions()
    {
        UserEvent::factory()->create(['user_id' => $this->user->id, 'event_id' => $this->event->id]);

        $response = $this->actingAs($this->user)
                         ->getJson("/api/subscriptions/{$this->user->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['user_id' => $this->user->id]);
    }

    public function test_subscribe_successfully()
    {
        $event = Event::factory()->create();
        
        $response = $this->actingAs($this->user)
                         ->postJson('/api/subscribe', [
                             'event_id' => $event->id,
                             'active' => true,
                         ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['message' => 'Registration completed successfully.']);

        $this->assertDatabaseHas('user_events', [
            'event_id' => $event->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_subscribe_event_full()
    {
        $event = Event::factory()->create(['capacity' => 1]);
        UserEvent::create(['event_id' => $event->id, 'user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
                         ->postJson('/api/subscribe', [
                             'event_id' => $event->id,
                             'active' => true,
                         ]);

        $response->assertStatus(403)
                 ->assertJsonFragment(['message' => 'Maximum capacity for this event has been reached.']);
    }

    public function test_cancel_subscription_successfully()
    {
        $subscription = UserEvent::create([
            'event_id' => $this->event->id,
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)
                         ->putJson("/api/cancel-subscription/{$subscription->event_id}", [
                             'active' => false,
                         ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Registration successfully cancelled.']);
    }
}
