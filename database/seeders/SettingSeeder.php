<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('settings')->insert([
      ['name' => 'email', 'value' => 'infopdr@pdrrealestate.com'],
      ['name' => 'phone', 'value' => '+213 982 420 400'],
      ['name' => 'whatsapp', 'value' => '+213 982 420 400'],
      ['name' => 'facebook', 'value' => 'https://www.facebook.com/TMMS.rs/'],
      ['name' => 'instagram', 'value' => 'https://www.instagram.com/mms_realestate/'],
      ['name' => 'twitter', 'value' => ''],
      ['name' => 'youtube', 'value' => ''],
      ['name' => 'telegram', 'value' => ''],
      ['name' => 'linkedin', 'value' => ''],
      ['name' => 'home_imgs', 'value' => ''],
      ['name' => 'desc', 'value' => ''],
      ['name' => 'desc_ar', 'value' => ''],
      ['name' => 'keywords', 'value' => ''],
      ['name' => 'keywords_ar', 'value' => ''],
    ]);
  }
}
