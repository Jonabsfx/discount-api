<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Campaign;
use App\Models\Discount;

class ProductTest extends TestCase
{
    protected $endpoint = '/products';

    public function test_get_all_Products()
    {
        Product::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(Product::count(), 'data');
        $response->assertStatus(200);
    }

    public function test_error_get_single_Product()
    {
        $product_id = 1918;

        $response = $this->getJson("{$this->endpoint}/{$product_id}");

        $response->assertStatus(404);
    }

    public function test_get_single_Product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$product->id}");

        $response->assertStatus(200);
    }

    public function test_validations_store_Product()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => '',
            'description' => '',
            'price' => ''
        ]);

        $response->assertStatus(422);
    }

    public function test_store_Product()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => 'Camisa do Fortaleza',
            'description' => 'A camisa mais bonita do mundo',
            'price' => 139.99
        ]);

        $response->assertStatus(200);
    }

    public function test_update_Product()
    {
        $product = Product::factory()->create();

        $data = [
            'name' => "Panelada",
            'description' => "Maior espetáculo na terra",
            'price' => 30.0
        ];

        $response = $this->putJson("$this->endpoint/camisa-do-kanal", $data);
        $response->assertStatus(404);

        $response = $this->putJson("$this->endpoint/{$product->id}", []);
        $response->assertStatus(422);

        $response = $this->putJson("$this->endpoint/{$product->id}", $data);
        $response->assertStatus(200);
    }

    public function test_delete_Product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/camisa-do-kanal");
        $response->assertStatus(404);

        $response = $this->deleteJson("{$this->endpoint}/{$product->id}");
        $response->assertStatus(204);

    }
}
