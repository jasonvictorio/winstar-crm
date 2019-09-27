<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(WinstarCRM\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});

$factory->define(WinstarCRM\User::class, function (Faker $faker) {
    $company_ids = WinstarCRM\Company::all()->pluck('id')->toArray();
    $role_ids = WinstarCRM\Role::all()->pluck('id')->toArray();
    return [
        'company_id' => $faker->randomElement($company_ids),
        'role_id' => $faker->randomElement($role_ids),
        'name' => $faker->name,
        'avatar' => 'default.png',
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('password'),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});

$factory->define(WinstarCRM\StatusType::class, function (Faker $faker) {
    $company_ids = WinstarCRM\Company::all()->pluck('id')->toArray();
    $user_ids = WinstarCRM\User::all()->pluck('id')->toArray();
    return [
        'name' => $faker->numerify('Status type ##'),
        'company_id' => $faker->randomElement($company_ids),
        'user_id' => $faker->randomElement($user_ids),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});

$factory->define(WinstarCRM\Status::class, function (Faker $faker) {
    $company_ids = WinstarCRM\Company::all()->pluck('id')->toArray();
    $user_ids = WinstarCRM\User::all()->pluck('id')->toArray();
    $status_type_ids = WinstarCRM\StatusType::all()->pluck('id')->toArray();
    return [
        'name' => $faker->numerify('Status ##'),
        'company_id' => $faker->randomElement($company_ids),
        'user_id' => $faker->randomElement($status_type_ids),
        'status_type_id' => $faker->randomElement($status_type_ids),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});

$factory->define(WinstarCRM\NatureOfContact::class, function (Faker $faker) {
    $company_ids = WinstarCRM\Company::all()->pluck('id')->toArray();
    $user_ids = WinstarCRM\User::all()->pluck('id')->toArray();
    return [
        'name' => $faker->numerify('Nature of contact ##'),
        'company_id' => $faker->randomElement($company_ids),
        'user_id' => $faker->randomElement($user_ids),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});

$factory->define(WinstarCRM\Customer::class, function (Faker $faker) {
    $company_ids = WinstarCRM\Company::all()->pluck('id')->toArray();
    $user_ids = WinstarCRM\User::all()->pluck('id')->toArray();
    $status_ids = WinstarCRM\Status::all()->pluck('id')->toArray();
    $nature_of_contact_ids = WinstarCRM\NatureOfContact::all()->pluck('id')->toArray();
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'company_id' => $faker->randomElement($company_ids),
        'user_id' => $faker->randomElement($user_ids),
        'status_id' => $faker->randomElement($status_ids),
        'nature_of_contact_id' => $faker->randomElement($nature_of_contact_ids),
        'first_contacted' => $faker->dateTimeBetween('-2 months', 'now'),
        'last_contacted' => $faker->dateTimeBetween('now', '2 months'),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});

$factory->define(WinstarCRM\Project::class, function (Faker $faker) {
    $company_ids = WinstarCRM\Company::all()->pluck('id')->toArray();
    $user_ids = WinstarCRM\User::all()->pluck('id')->toArray();
    $status_ids = WinstarCRM\Status::all()->pluck('id')->toArray();
    $customer_ids = WinstarCRM\Customer::all()->pluck('id')->toArray();
    return [
        'name' => $faker->numerify('Project ##'),
        'start_date' => $faker->dateTimeBetween('-2 months', 'now'),
        'estimated_end_date' => $faker->dateTimeBetween('now', '2 months'),
        'company_id' => $faker->randomElement($company_ids),
        'user_id' => $faker->randomElement($user_ids),
        'status_id' => $faker->randomElement($status_ids),
        'customer_id' => $faker->randomElement($customer_ids),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});

$factory->define(WinstarCRM\TaskType::class, function (Faker $faker) {
    $company_ids = WinstarCRM\Company::all()->pluck('id')->toArray();
    $user_ids = WinstarCRM\User::all()->pluck('id')->toArray();
    return [
        'name' => $faker->numerify('Task type ##'),
        'company_id' => $faker->randomElement($company_ids),
        'user_id' => $faker->randomElement($user_ids),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});

$factory->define(WinstarCRM\TaskCategory::class, function (Faker $faker) {
    $company_ids = WinstarCRM\Company::all()->pluck('id')->toArray();
    $user_ids = WinstarCRM\User::all()->pluck('id')->toArray();
    return [
        'name' => $faker->numerify('Task category ##'),
        'company_id' => $faker->randomElement($company_ids),
        'user_id' => $faker->randomElement($user_ids),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});

$factory->define(WinstarCRM\Task::class, function (Faker $faker) {
    $company_ids = WinstarCRM\Company::all()->pluck('id')->toArray();
    $user_ids = WinstarCRM\User::all()->pluck('id')->toArray();
    $project_ids = WinstarCRM\Project::all()->pluck('id')->toArray();
    $status_ids = WinstarCRM\Status::all()->pluck('id')->toArray();
    $task_type_ids = WinstarCRM\TaskType::all()->pluck('id')->toArray();
    $task_category_ids = WinstarCRM\TaskCategory::all()->pluck('id')->toArray();
    return [
        'name' => $faker->numerify('Task ##'),
        'description' => $faker->sentence,
        'created_date' => $faker->dateTimeBetween('-2 months', 'now'),
        'deadline_date' => $faker->dateTimeBetween('now', '2 months'),
        'company_id' => $faker->randomElement($company_ids),
        'user_id' => $faker->randomElement($user_ids),
        'project_id' => $faker->randomElement($project_ids),
        'status_id' => $faker->randomElement($status_ids),
        'task_type_id' => $faker->randomElement($task_type_ids),
        'task_category_id' => $faker->randomElement($task_category_ids),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});
