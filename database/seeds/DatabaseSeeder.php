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
            'name' => 'Super Admin',
            'email' => 'superadmin@winstar.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ],[
            'company_id' => 1,
            'role_id' => 2,
            'name' => 'Just Admin',
            'email' => 'admin@winstar.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ],[
            'company_id' => 1,
            'role_id' => 3,
            'name' => 'Staff 01',
            'email' => 'staff@winstar.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ],[
            'company_id' => 1,
            'role_id' => 4,
            'name' => 'John Wayne',
            'email' => 'customer@winstar.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]]);

        // \WinstarCRM\User::find(1)->sendEmailVerificationNotification();

        DB::table('status_types')->insert([
            'name' => 'Status type 1',
            'company_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('status')->insert([
            'name' => 'Status 1',
            'company_id' => 1,
            'user_id' => 1,
            'status_type_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('nature_of_contacts')->insert([
            'name' => 'Nature of contact 1',
            'company_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('customers')->insert([
            'first_name' => 'Tony',
            'last_name' => 'Stark',
            'company_id' => 1,
            'user_id' => 1,
            'status_id' => 1,
            'nature_of_contact_id' => 1,
            'hear_about_us' => 'On the internets',
            'first_contacted' => Carbon::now()->format('Y-m-d H:i:s'),
            'last_contacted' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
