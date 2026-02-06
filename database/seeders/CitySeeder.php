<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed data from CSV
        $file = database_path('data/CityData.csv');
        $csv = fopen($file, 'r');
        while (($row = fgetcsv($csv)) !== false) {
            if ($row[0] == 'id') {
                continue;
            }
            DB::table('cities')->insert([
                'id' => $row[0],
                'name' => $row[1],
                'name_ar' => $row[2],
                'slug' => Str::slug($row[1]),
            ]);
        }
        fclose($csv);
    }
}
