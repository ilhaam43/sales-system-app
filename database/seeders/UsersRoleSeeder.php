<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use carbon\Carbon;

class UsersRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_role')->insert([
            'role' => 'superadmin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users_role')->insert([
            'role' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users_role')->insert([
            'role' => 'researcher',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users_role')->insert([
            'role' => 'inquirer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users_role')->insert([
            'role' => 'auditor',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
