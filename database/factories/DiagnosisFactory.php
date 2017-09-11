<?php

$factory->define(App\Diagnosis::class, function (Faker\Generator $faker) {
    return [
        "patient_id" => factory('App\Patient')->create(),
        "diagnose_type_id" => factory('App\DiagnosesType')->create(),
        "diagnose_date" => $faker->date("Y-m-d", $max = 'now'),
        "notes" => $faker->name,
    ];
});
