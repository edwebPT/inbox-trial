<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Campaign;
use App\Services\CampaignService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class CampaignSendApiTest extends TestCase
{
    use RefreshDatabase;

    public function can_dispatch_campaign()
    {
        // Create a campaign
        $campaign = Campaign::factory()->create([
            'status' => 'draft',
        ]);

        // Mock the CampaignService
        $mockService = Mockery::mock(CampaignService::class);

        // Match ANY argument (the controller might call dispatch($campaign) or just dispatch())
        $mockService->shouldReceive('dispatch')
            ->once()
            ->andReturnNull();

        // Bind the mock to the service container
        $this->app->instance(CampaignService::class, $mockService);

        // Call the API endpoint
        $response = $this->postJson("/api/campaigns/{$campaign->id}/dispatch");

        // Assert successful response
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Campaign dispatched.', // match the actual response
            ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
