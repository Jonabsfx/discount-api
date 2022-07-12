<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;

class GroupController extends Controller
{
    protected $entity;

    public function __construct(Group $model)
    {
        $this->entity = $model;
    }

    private function findGroup($id)
    {
        return $this->entity->where('id', $id)->firstOrFail();
    }
    public function index()
    {
        $groups = $this->entity->with('cities')->get();

        return GroupResource::collection($groups);
    }

    public function store(Request $request)
    {
        if(!empty($request->name)){
            $this->entity
                    ->create([
                        'name' => $request->name
                    ]);

            return response()->json(['message'=>'Group created successfully'], 200);
        }

        return response()->json(['message'=>'Group name can not be empty'], 400);
    }

    public function show($id)
    {
        $group = $this->findGroup($id);

        return new GroupResource($group);
    }

    public function update(Request $request, $id)
    {
        if(!empty($request->name)){
          $group = $this->findGroup($id);

          $group->update($request);

          return response()->json(['message'=>'Grup name updated successfully'], 200);
        }

        return response()->json(['message'=>'Group name can not be empty'], 400);
    }

    public function destroy($id)
    {
        $group = $this->findGroup($id);

        $group->delete();

        return response()->json(['message'=>'Group deleted successfully'], 200);
    }

    public function addCity($id, $city_id)
    {
        $city = \App\Models\City::findorFail($city_id);
        $group = $this->findGroup($id);

        $response = $group->cities()->save($city);

        return response()->json(['message'=>'City added successfully'], 200);
    }
}
