<?php

$factory->define(App\Treatment::class, function (Faker\Generator $faker) {
    return [
        "patient_id" => factory('App\Patient')->create(),
        "treatment_type_id" => factory('App\TreatmentType')->create(),
        "treatment_stage_id" => factory('App\TreatmentStage')->create(),
        "start_date" => $faker->date("Y-m-d", $max = 'now'),
        "end_date" => $faker->date("Y-m-d", $max = 'now'),
        "notes" => $faker->name,
    ];
});
