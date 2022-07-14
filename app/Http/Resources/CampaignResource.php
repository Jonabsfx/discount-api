<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->isActive,
            'group' => new GroupResource($this->group()->first()),
            'discounts' => DiscountResource::collection($this->discounts),
        ];
    }
}
