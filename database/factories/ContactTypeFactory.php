<?php

$factory->define(App\ContactType::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
    ];
});
