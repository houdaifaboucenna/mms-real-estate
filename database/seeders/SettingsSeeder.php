<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;


class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $settings = Settings::create([
        'facebook' => 'https://www.facebook.com/TMMS.rs/',
        'instagram' => 'https://www.instagram.com/mms_realestate/',
        'whatsapp' => '+90 551 799 66 96',
        'phone' => '+90 551 747 36 52',
        'email' => 'infopdr@pdrrealestate.com',
      ]);
    }
}
