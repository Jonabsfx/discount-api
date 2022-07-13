<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cities' => CityResource::collection($this->cities()->get()),
            'active_campaign' => new CampaignResource($this->campaigns->where('is_active' === TRUE)->first()),
        ];
    }
}
