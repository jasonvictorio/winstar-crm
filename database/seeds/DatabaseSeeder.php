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
        $companies = factory(WinstarCRM\Company::class, 3)->create();
        $users = factory(WinstarCRM\User::class, 3)->create();
    }
}
