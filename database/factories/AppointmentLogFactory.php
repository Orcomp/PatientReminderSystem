<?php

$factory->define(App\AppointmentLog::class, function (Faker\Generator $faker) {
    return [
        "appointment_id" => factory('App\Appointment')->create(),
        "appointment_time" => $faker->date("Y-m-d H:i:s", $max = 'now'),
        "note" => $faker->name,
        "reschedule_reason_id" => factory('App\RescheduleReason')->create(),
        "created_by_id" => factory('App\User')->create(),
    ];
});
