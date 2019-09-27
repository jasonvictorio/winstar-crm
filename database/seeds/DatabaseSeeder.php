<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'name' => 'Winstar',
            'address' => 'Auckland, NZ',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('roles')->insert([[
            'name' => 'Superadmin',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ], [
            'name' => 'Admin',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ], [
            'name' => 'Staff',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ], [
            'name' => 'Customer',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]]);
        DB::table('users')->insert([[
            'company_id' => 1,
            'role_id' => 1,
            'avatar' => 'default.png',
            'name' => 'Super Admin',
            'email' => 'superadmin@winstar.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ],[
            'company_id' => 1,
            'role_id' => 2,
            'avatar' => 'default.png',
            'name' => 'Just Admin',
            'email' => 'admin@winstar.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ],[
            'company_id' => 1,
            'role_id' => 3,
            'avatar' => 'default.png',
            'name' => 'Staff 01',
            'email' => 'staff@winstar.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ],[
            'company_id' => 1,
            'role_id' => 4,
            'avatar' => 'default.png',
            'name' => 'John Wayne',
            'email' => 'customer@winstar.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]]);
        factory(WinstarCRM\Company::class, 4)->create();
        factory(WinstarCRM\User::class, 4)->create();
        factory(WinstarCRM\StatusType::class, 5)->create();
        factory(WinstarCRM\Status::class, 5)->create();
        factory(WinstarCRM\NatureOfContact::class, 5)->create();
        factory(WinstarCRM\Customer::class, 50)->create();
        factory(WinstarCRM\Project::class, 50)->create();
        factory(WinstarCRM\TaskType::class, 5)->create();
        factory(WinstarCRM\TaskCategory::class, 5)->create();
        factory(WinstarCRM\Task::class, 50)->create();

        // \WinstarCRM\User::find(1)->sendEmailVerificationNotification();
    }
}
