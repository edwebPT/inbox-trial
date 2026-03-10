<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Contact;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;


    public function can_list_contacts()
    {
        Contact::factory()->create(['name' => 'Alice']);

        $response = $this->getJson('/api/contacts');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Alice']);
    }


    public function can_create_contact()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'status' => 'active', // optional, controller handles default
        ];

        $response = $this->postJson('/api/contacts', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['email' => 'john@example.com']);

        $this->assertDatabaseHas('contacts', [
            'email' => 'john@example.com',
        ]);
    }


    public function can_unsubscribe_contact()
    {
        $contact = Contact::factory()->create(['status' => 'active']);

        $response = $this->postJson("/api/contacts/{$contact->id}/unsubscribe");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Unsubscribed successfully']);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'status' => 'unsubscribed',
        ]);
    }


    public function returns_404_if_contact_not_found()
    {
        $response = $this->getJson('/api/contacts/9999');

        $response->assertStatus(404);
    }
}
