<?php

$factory->define(App\Patient::class, function (Faker\Generator $faker) {
    return [
        "first_name" => $faker->name,
        "last_name" => $faker->name,
        "gender" => collect(["Male","Female",])->random(),
        "birth_date" => $faker->date("Y-m-d", $max = 'now'),
        "schooled" => 1,
        "notes" => $faker->name,
    ];
});
