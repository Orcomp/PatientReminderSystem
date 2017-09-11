<?php

$factory->define(App\Contact::class, function (Faker\Generator $faker) {
    return [
        "first_name" => $faker->name,
        "last_name" => $faker->name,
        "mobile_number" => $faker->name,
        "phone_number" => $faker->name,
        "email" => $faker->safeEmail,
        "contact_type_id" => factory('App\ContactType')->create(),
        "designation_type_id" => factory('App\DesignationType')->create(),
        "user_id" => factory('App\User')->create(),
        "is_primary" => 0,
        "patient_id" => factory('App\Patient')->create(),
    ];
});
