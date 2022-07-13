<?php

namespace Tests\Feature;

use App\Models\{
    Campaign,
    Group,
    City
};
use Tests\TestCase;

class GroupTest extends TestCase
{
    protected $endpoint = '/groups';

    public function test_get_all_groups()
    {
        Group::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(Group::count(), 'data');
        $response->assertStatus(200);
    }

    public function test_error_get_single_Group()
    {
        $group_id = 1918;

        $response = $this->getJson("{$this->endpoint}/{$group_id}");

        $response->assertStatus(404);
    }

    public function test_get_single_Group()
    {
        $group = Group::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$group->id}");

        $response->assertStatus(200);
    }

    public function test_validations_store_Group()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => ''
        ]);

        $response->assertStatus(400);
    }

    public function test_store_Group()
    {

        $response = $this->postJson($this->endpoint, [
            'name' => 'Pontos de venda da Cajuína São Gerardo'
        ]);

        $response->assertStatus(200);
    }

    public function test_update_Group()
    {
        $group = Group::factory()->create();

        $data = [
            'name' => "Cidades que a galera toma Guaraná Jesus"
        ];

        $response = $this->putJson("$this->endpoint/the-breakfast-club", $data);
        $response->assertStatus(404);

        $response = $this->putJson("$this->endpoint/{$group->id}", []);
        $response->assertStatus(400);

        $response = $this->putJson("$this->endpoint/{$group->id}", $data);
        $response->assertStatus(200);
    }

    public function test_delete_Group()
    {
        $group = Group::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/the-breakfast-club");
        $response->assertStatus(404);

        $response = $this->deleteJson("{$this->endpoint}/{$group->id}");
        $response->assertStatus(204);

    }

    public function test_add_City()
    {
        $city = City::factory()->create();
        $group = Group::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$group->id}/add-city/{$city->id}");
        $response->assertStatus(200);
    }

    public function test_add_Campaign()
    {
        $campaign = Campaign::factory()->create();
        $group = Group::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$group->id}/add-campaign/{$campaign->id}");
        $response->assertStatus(200);
    }
}
