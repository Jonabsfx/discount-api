<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    public function definition()
    {
        $faker = \Faker\Factory::create('pt_BR');

        $path = "/var/www/app/jsons/cities.json";

        $strJsonFileContents = file_get_contents($path);
        $citiesArray = json_decode($strJsonFileContents, true);
        $name = $citiesArray[array_rand($citiesArray)];
        $id  = array_search($name, $citiesArray);

        return [
            'name' => $name,
            'id' => $id,
            'state' => $faker->state()
        ];
    }
}
