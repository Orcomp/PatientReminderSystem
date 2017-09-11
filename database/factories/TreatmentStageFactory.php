<?php

$factory->define(App\TreatmentStage::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
    ];
});
