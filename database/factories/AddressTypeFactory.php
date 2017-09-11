<?php

$factory->define(App\AddressType::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
    ];
});
