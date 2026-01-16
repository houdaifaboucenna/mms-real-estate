<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
          $table->string("keywords")->after("twitter")->nullable();
          $table->string("keywords_ar")->after("keywords")->nullable();
          $table->string("desc")->after("keywords_ar")->nullable();
          $table->string("desc_ar")->after("desc")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
          $table->dropColumn('keywords');
          $table->dropColumn('keywords_ar');
          $table->dropColumn("desc");
          $table->dropColumn("desc_ar");
        });
    }
}
