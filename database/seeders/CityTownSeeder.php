<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CityTownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed data from CSV
        $file = database_path('data/CityTownData.csv');
        $csv = fopen($file, 'r');
        while (($row = fgetcsv($csv)) !== false) {
            if ($row[0] == 'id') {
                continue;
            }
            DB::table('city_towns')->insert([
                'id' => $row[0],
                'name' => $row[1],
                'name_ar' => $row[2],
                'city_id' => $row[3],
                'slug' => Str::slug($row[1]),
            ]);
        }
        fclose($csv);
    }
}
