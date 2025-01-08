<?php

namespace App\Http\Controllers;

use Faker\Factory as Faker;

class Utils
{
    public static function loadJsonFile(string $fileName)
    {
        $jsonPath = __DIR__ . '/' . $fileName;
        if (file_exists($jsonPath)) {
            $jsonData = file_get_contents($jsonPath);
            return json_decode($jsonData, true);
        }
        return [];
    }

    public static function generateFakeUsers($count)
    {
        $faker = Faker::create();

        return array_map(function () use ($faker) {
            return [
                'name' => $faker->name,
                'birthDate' => $faker->date,
                'email' => $faker->email,
            ];
        }, range(1, $count));
    }

    public static function writeFile(string $fileName, string $key, $data)
    {
        $path = __DIR__ . '/' . $fileName;

        if ($key) file_put_contents($path, json_encode([$key => $data], JSON_PRETTY_PRINT));
        else file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }
}
