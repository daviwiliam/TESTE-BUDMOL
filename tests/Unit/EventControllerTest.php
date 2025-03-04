<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'admin' => 1,
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        
        $this->user = User::factory()->create([
            'admin' => 0,
            'name' => 'Regular User',
            'email' => 'user@example.com',
        ]);
    }

    public function test_index_returns_all_events()
    {
        Event::factory()->create(['user_id' => $this->admin->id]);

        $response = $this->actingAs($this->admin)->getJson('/api/events');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }

    public function test_store_creates_event_for_admin()
    {
        $eventData = [
            'title' => 'Test Event',
            'description' => 'This is a test event.',
            'start_date' => '2025-03-10',
            'end_date' => '2025-03-10',
            'time' => '07:57',
            'location' => 'Test Location',
            'capacity' => 100,
            'status' => 'open',
        ];

        $response = $this->actingAs($this->admin)->postJson('/api/events', $eventData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => $eventData['title']]);
    }

    public function test_store_fails_for_non_admin()
    {
        $eventData = [
            'title' => 'Test Event',
            'description' => 'This is a test event.',
            'start_date' => '2025-03-10',
            'end_date' => '2025-03-10',
            'time' => '20:00',
            'location' => 'Test Location',
            'capacity' => 100,
            'status' => 'open',
        ];

        $response = $this->actingAs($this->user)->postJson('/api/events', $eventData);

        $response->assertStatus(403);
    }

    public function test_show_returns_event()
    {
        $event = Event::factory()->create(['user_id' => $this->admin->id]);

        $response = $this->actingAs($this->admin)->getJson('/api/events/' . $event->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $event->title]);
    }

    public function test_update_modifies_event_for_admin()
    {
        $event = Event::factory()->create(['user_id' => $this->admin->id]);

        $updatedData = [
            'title' => 'Updated Event',
            'description' => 'This is an updated test event.',
            'start_date' => '2025-03-15',
            'end_date' => '2025-03-15',
            'time' => '03:33',
            'location' => 'Updated Location',
            'capacity' => 150,
            'status' => 'closed',
        ];

        $response = $this->actingAs($this->admin)->putJson('/api/events/' . $event->id, $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $updatedData['title']]);
    }

    public function test_update_fails_for_non_admin()
    {
        $event = Event::factory()->create(['user_id' => $this->admin->id]);

        $updatedData = [
            'title' => 'Updated Event',
            'description' => 'This is an updated test event.',
            'start_date' => '2025-03-15',
            'time' => '10:00',
            'location' => 'Updated Location',
            'capacity' => 150,
            'status' => 'closed',
        ];

        $response = $this->actingAs($this->user)->putJson('/api/events/' . $event->id, $updatedData);

        $response->assertStatus(403);
    }

    public function test_destroy_deletes_event_for_admin()
    {
        $event = Event::factory()->create(['user_id' => $this->admin->id]);

        $response = $this->actingAs($this->admin)->deleteJson('/api/events/' . $event->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_destroy_fails_for_non_admin()
    {
        $event = Event::factory()->create(['user_id' => $this->admin->id]);

        $response = $this->actingAs($this->user)->deleteJson('/api/events/' . $event->id);

        $response->assertStatus(403);
    }
}
