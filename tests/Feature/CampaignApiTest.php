<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Campaign;
use App\Models\ContactList;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CampaignApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_campaigns()
    {
        $contactList = ContactList::factory()->create();
        Campaign::factory()->count(3)->create(['contact_list_id' => $contactList->id]);

        $response = $this->getJson('/api/campaigns');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'subject', 'body', 'contact_list_id', 'status', 'scheduled_at', 'created_at', 'updated_at']
            ]);
    }

    public function test_can_create_campaign()
    {
        $contactList = ContactList::factory()->create();

        $payload = [
            'subject' => 'Test Campaign',
            'body' => 'This is a test',
            'contact_list_id' => $contactList->id,
            'scheduled_at' => now()->addHour()->toDateTimeString(),
        ];

        $response = $this->postJson('/api/campaigns', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['subject' => 'Test Campaign']);

        $this->assertDatabaseHas('campaigns', ['subject' => 'Test Campaign']);
    }

    public function test_can_show_campaign()
    {
        $contactList = ContactList::factory()->create();
        $campaign = Campaign::factory()->create(['contact_list_id' => $contactList->id]);

        $response = $this->getJson("/api/campaigns/{$campaign->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $campaign->id]);
    }
}
