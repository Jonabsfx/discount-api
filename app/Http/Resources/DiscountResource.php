<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;

class DiscountResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'value' => $this->value,
            'product' => new ProductResource(Product::findOrFail($this->product_id)),
        ];
    }
}
