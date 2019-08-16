<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use WinstarCRM\Status;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker) {
    $company_ids = WinstarCRM\Company::all()->pluck('id')->toArray();
    return [
        'company_id' => $faker->randomElement($company_ids),
        'status' => $faker->sentence(),
        'type' => $faker->randomElement(['type1', 'type2']),
    ];
});
