<?php

$factory->define(App\RescheduleReason::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
    ];
});
