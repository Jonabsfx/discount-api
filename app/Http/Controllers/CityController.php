<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Http\Resources\CityResource;
use App\Models\City;
class CityController extends Controller
{
    protected $entity;

    public function __construct(City $model)
    {
        $this->entity = $model;
    }

    private function findCity($id)
    {
        return $this->entity->where('id', $id)->firstOrFail();
    }

    private function validatorIBGE($city, $state_name)
    {
        $strJsonFileContents = file_get_contents(__DIR__ . "/cities.json");
        $citiesArray = json_decode($strJsonFileContents, true);

        $strJsonFileContents = file_get_contents(__DIR__ . "/states.json");
        $statesArray = json_decode($strJsonFileContents, true);

        if(in_array($city, $citiesArray)){
            foreach($statesArray as $state){
                if($state_name === $state["nome"])
                    return TRUE;
            }
            return response()->json(['message'=>'State dont exist'], 400);
        }else{
            return response()->json(['message'=>'City dont exist'], 400);
        }
    }

    public function index()
    {
        $cities = $this->entity->get();

        return CityResource::collection($cities);
    }
    public function store(StoreCityRequest $request)
    {
        $data = $request->validated();

        if($this->validatorIBGE($data['name'], $data['state']) === TRUE){
            $strJsonFileContents = file_get_contents(__DIR__ . "/cities.json");
            $citiesArray = json_decode($strJsonFileContents, true);

            $this->entity
                    ->create([
                        'id' => array_search($data['name'], $citiesArray),
                        'name' => $data['name'],
                        'state' => $data['state']
                    ]);
            return response()->json(['message'=>'City created successfully'], 200);
        }

        return $this->validatorIBGE($data['name'], $data['state']);

    }
    public function show($id)
    {
        $city = $this->findCity($id);

        return new CityResource($city);
    }

    public function update(StoreCityRequest $request, $id)
    {
        $data = $request->validated();

        if($this->validatorIBGE($data['name'], $data['state']) === TRUE ){
            $strJsonFileContents = file_get_contents(__DIR__ . "/cities.json");
            $citiesArray = json_decode($strJsonFileContents, true);

            $city = $this->findCity($id);

            $city->update([
                'id' => array_search($data['name'], $citiesArray),
                'name' => $data['name'],
                'state' => $data['state']
            ]);

            return response()->json(['message'=>'City updated successfully'], 200);
        }

        return $this->validatorIBGE($data['name'], $data['state']);
    }
    public function destroy($id)
    {
        $city = $this->findCity($id);

        $city->delete();

        return response()->json(['message'=>'City deleted successfully'], 204);
    }
}
