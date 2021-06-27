<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use carbon\Carbon;

class UsersStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_status')->insert([
            'status' => 'Actived',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users_status')->insert([
            'status' => 'Blocked',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
