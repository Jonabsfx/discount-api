<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Resources\CampaignResource;

class CampaignController extends Controller
{
    protected $entity;

    public function __construct(Campaign $model)
    {
        $this->entity = $model;
    }

    private function findCampaign($id)
    {   var_dump($this->entity->findOrFail($id));
        die();
    }
    public function index()
    {
        $campaigns = $this->entity->get();

        return CampaignResource::collection($campaigns);
    }

    public function store(Request $request)
    {

        if(!empty($request->name)){
            $response = $this->entity
                    ->create([
                        'name' => $request->name,
                    ]);
            return response()->json($response, 200);
        }

        return response()->json(['message'=>'Campaign name can not be empty'], 400);
    }

    public function show($id)
    {
        $campaign = $this->findCampaign($id);
        return new CampaignResource($campaign);
    }

    public function update(Request $request, $id)
    {
        if(!empty($request->name)){
          $campaign = $this->findCampaign($id);

          $campaign->update([
            'name' => $request->name
          ]);

          return response()->json(['message'=>'Campaign name updated successfully'], 200);
        }

        return response()->json(['message'=>'Campaign name can not be empty'], 400);
    }

    public function destroy($id)
    {
        $campaign = $this->findCampaign($id);

        $campaign->delete();

        return response()->json(['message'=>'Campaign deleted successfully'], 204);
    }

    public function active($id)
    {
        $campaign = $this->findCampaign($id);

        if($campaign->group() != null){
            $group = $campaign->group()->firstOrFail();
            $campaign_active = $group->campaigns()->getRelated()->where('is_active', 1)->first();

            if($campaign_active != null){
                $campaign_active->is_active = 0;
                $campaign_active->save();
            }

            $campaign->is_active = 1;
            $campaign->save();

            return response()->json(['message'=>'Campaign actived successfully'], 200);
        }

        return response()->json(['message'=>'Campaign needs to be associated with a group'], 400);
    }
}
