<?php

$factory->define(App\DiagnosesType::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
    ];
});
