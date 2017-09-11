<?php

$factory->define(App\City::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "country_id" => factory('App\Country')->create(),
    ];
});
