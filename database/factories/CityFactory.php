<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('pt_BR');

        $path = 'app/Http/Controllers/cities.json';

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
