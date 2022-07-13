<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Group;

class CampaignTest extends TestCase
{
    protected $endpoint = '/campaigns';

    public function test_get_all_Campaigns()
    {
        Campaign::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(Campaign::count(), 'data');
        $response->assertStatus(200);
    }

    public function test_error_get_single_Campaign()
    {
        $campaign_id = 1918;

        $response = $this->getJson("{$this->endpoint}/{$campaign_id}");

        $response->assertStatus(404);
    }

    public function test_get_single_Campaign()
    {
        $campaign = Campaign::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$campaign->id}");

        $response->assertStatus(200);
    }

    public function test_validations_store_Campaign()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => ''
        ]);

        $response->assertStatus(400);
    }

    public function test_store_Campaign()
    {

        $response = $this->postJson($this->endpoint, [
            'name' => 'O gerente endoidou'
        ]);

        $response->assertStatus(200);
    }

    public function test_update_Campaign()
    {
        $campaign = Campaign::factory()->create();

        $data = [
            'name' => "Queima de estoque"
        ];

        $response = $this->putJson("$this->endpoint/the-breakfast-club", $data);
        $response->assertStatus(404);

        $response = $this->putJson("$this->endpoint/{$campaign->id}", []);
        $response->assertStatus(400);

        $response = $this->putJson("$this->endpoint/{$campaign->id}", $data);
        $response->assertStatus(200);
    }

    public function test_delete_Campaign()
    {
        $campaign = Campaign::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/the-breakfast-club");
        $response->assertStatus(404);

        $response = $this->deleteJson("{$this->endpoint}/{$campaign->id}");
        $response->assertStatus(204);

    }

    public function test_active_Campaign()
    {
        $campaign = Campaign::factory()->create();
        $group = Group::factory()->create();

        $group->campaigns()->save($campaign);

        $response = $this->getJson("{$this->endpoint}/{$campaign->id}/active");
        $response->assertStatus(200);

    }
}
