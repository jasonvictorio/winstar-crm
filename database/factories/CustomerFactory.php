<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use WinstarCRM\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    $company_ids = WinstarCRM\Company::all()->pluck('id')->toArray();
    return [
        'company_id' => $faker->randomElement($company_ids),
        'next_follow_up_date' => $faker->randomElement($company_ids),
        'latest_contact_or_actions' => $faker->randomElement($company_ids),
        'latest_contact_or_actions' => $faker->randomElement($company_ids),
        'nature_of_contact' => $faker->randomElement($company_ids),
        'notes' => $faker->randomElement($company_ids),
        'first_contacted' => $faker->randomElement($company_ids),
        'last_contacted' => $faker->randomElement($company_ids),
        'days_since_last_contact' => $faker->randomElement($company_ids),
        'status_id' => $faker->randomElement($company_ids),
        'month_ordered' => $faker->randomElement($company_ids),
        'package_ordered' => $faker->randomElement($company_ids),
        'hear_about_us' => $faker->randomElement($company_ids),
        'up_sell' => $faker->randomElement($company_ids),
        'quote_total' => $faker->randomElement($company_ids),
        'addons' => $faker->randomElement($company_ids),
        'total' => $faker->randomElement($company_ids),
        'invoiced' => $faker->randomElement($company_ids),
        'annual_renewal_date' => $faker->randomElement($company_ids),
        'annual_renewal_amount' => $faker->randomElement($company_ids),
    ];
});
