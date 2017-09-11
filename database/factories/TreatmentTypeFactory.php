<?php

$factory->define(App\TreatmentType::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
    ];
});
