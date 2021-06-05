<?php

namespace Database\Seeders;

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
        $this->call(CountrySeeder::class);
        $this->call(UsersRoleSeeder::class);
        $this->call(SuperAdminSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
