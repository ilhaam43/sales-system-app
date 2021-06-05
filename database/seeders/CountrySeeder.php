<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use carbon\Carbon;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get(base_path('database/data/country.json'));
        $data = json_decode($file);

        foreach ($data as $d) {
            DB::table('country')->insert([
                'country_name' => $d->country ?: null,
                'created_at' => Carbon::now(),
                'updated_at'=> Carbon::now()
            ]);
        }
    }
}
