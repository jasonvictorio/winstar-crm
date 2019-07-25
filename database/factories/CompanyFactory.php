<?php

use Faker\Generator as Faker;

$factory->define(WinstarCRM\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address,
    ];
});
