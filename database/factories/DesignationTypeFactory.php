<?php

$factory->define(App\DesignationType::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
    ];
});
