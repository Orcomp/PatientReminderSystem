<?php

$factory->define(App\Address::class, function (Faker\Generator $faker) {
    return [
        "contact_id" => factory('App\Contact')->create(),
        "street" => $faker->name,
        "city_id" => factory('App\City')->create(),
        "state_id" => factory('App\State')->create(),
        "country_id" => factory('App\Country')->create(),
        "note" => $faker->name,
        "address_type_id" => factory('App\AddressType')->create(),
    ];
});
