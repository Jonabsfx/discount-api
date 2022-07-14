<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\City;

class CityTest extends TestCase
{
    protected $endpoint = '/cities';

    public function test_get_all_cities()
    {
        City::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(City::count(), 'data');
        $response->assertStatus(200);
    }

    public function test_error_get_single_city()
    {
        $city_id = 1918;

        $response = $this->getJson("{$this->endpoint}/{$city_id}");

        $response->assertStatus(404);
    }

    public function test_get_single_city()
    {
        $city = City::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$city->id}");

        $response->assertStatus(200);
    }

    public function test_validations_store_city()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => '',
            'state' => ''
        ]);

        $response->assertStatus(422);
    }

    public function test_store_city()
    {
        $path = "/var/www/app/jsons/cities.json";

        $strJsonFileContents = file_get_contents($path);
        $citiesArray = json_decode($strJsonFileContents, true);
        $name = $citiesArray[array_rand($citiesArray)];

        $response = $this->postJson($this->endpoint, [
            'name' => $name,
            'state' => 'Ceará'
        ]);

        $response->assertStatus(200);
    }

    public function test_update_city()
    {
        $city = City::factory()->create();

        $data = [
            'name' => $city->name,
            'state' => $city->state,
        ];

        $response = $this->putJson("$this->endpoint/paper-city", $data);
        $response->assertStatus(404);

        $response = $this->putJson("$this->endpoint/{$city->id}", []);
        $response->assertStatus(422);

        $response = $this->putJson("$this->endpoint/{$city->id}", $data);
        $response->assertStatus(200);
    }

    public function test_delete_city()
    {
        $city = City::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/paper-city");
        $response->assertStatus(404);

        $response = $this->deleteJson("{$this->endpoint}/{$city->id}");
        $response->assertStatus(204);
    }


}
