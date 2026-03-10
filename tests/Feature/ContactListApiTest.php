<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Contact;
use App\Models\ContactList;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactListApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_contact_lists()
    {
        ContactList::factory()->count(3)->create();

        $response = $this->getJson('/api/contact-lists');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'created_at', 'updated_at']
            ]);
    }

    public function test_can_create_contact_list()
    {
        $payload = ['name' => 'Test List'];

        $response = $this->postJson('/api/contact-lists', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment($payload);

        $this->assertDatabaseHas('contact_lists', $payload);
    }

    public function test_can_add_contact_to_list()
    {
        $contactList = ContactList::factory()->create();
        $contact = Contact::factory()->create();

        $response = $this->postJson("/api/contact-lists/{$contactList->id}/contacts", [
            'contact_id' => $contact->id,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['contact_list_id' => $contactList->id, 'contact_id' => $contact->id]);

        $this->assertDatabaseHas('contact_contact_list', [
            'contact_list_id' => $contactList->id,
            'contact_id' => $contact->id,
        ]);
    }
}
