<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Campaign;
use App\Models\Discount;

class DiscountTest extends TestCase
{
    protected $endpoint = '/discount';
    public function test_associate_Campaign()
    {
        $product = Product::factory()->create();
        $campaign = Campaign::factory()->create();

        $response = $this->postJson("$this->endpoint/{$campaign->id}/{$product->id}", [
            'value' => 20.5
        ]);
        $response->assertStatus(200);

    }

    public function test_edit_associated_Campaign()
    {
        $discount = Discount::inRandomOrder()->first();
        $data = [
            'value' => 12.5
        ];

        $response = $this->putJson("{$this->endpoint}/{$discount->campaign_id}/{$discount->product_id}", []);
        $response->assertStatus(400);

        $response = $this->putJson("{$this->endpoint}/{$discount->campaign_id}/{$discount->product_id}", $data);
        $response->assertStatus(200);
    }

    public function test_delete_associated_Campaign()
    {
        $discount = Discount::inRandomOrder()->first();

        $response = $this->deleteJson("{$this->endpoint}/{$discount->campaign_id}/{$discount->product_id}");
        $response->assertStatus(204);

    }


}
