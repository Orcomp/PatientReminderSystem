<?php

$factory->define(App\Appointment::class, function (Faker\Generator $faker) {
    return [
        "patient_id" => factory('App\Patient')->create(),
        "user_id" => factory('App\User')->create(),
        "appointment_time" => $faker->date("Y-m-d H:i:s", $max = 'now'),
        "confirmed_at" => $faker->date("Y-m-d H:i:s", $max = 'now'),
        "contacted_contact_id" => factory('App\Contact')->create(),
        "notes" => $faker->name,
        "created_by_id" => factory('App\User')->create(),
    ];
});
