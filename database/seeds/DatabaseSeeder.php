<?php

use Illuminate\Database\Seeder;

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
        ]);
        DB::table('users')->insert([
            'access' => 0,
            'company_id' => 1,
            'name' => 'Super Admin',
            'email' => 'superadmin@winstar.com',
            'password' => bcrypt('password'),
        ]);
        DB::table('status_types')->insert([
            'name' => 'Status type 1',
            'company_id' => 1,
        ]);
    }
}
