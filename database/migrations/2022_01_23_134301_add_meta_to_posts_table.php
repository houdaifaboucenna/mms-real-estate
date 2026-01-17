<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('keywords')->after('content_ar')->nullable();
            $table->string('keywords_ar')->after('keywords')->nullable();
            $table->string('short')->after('keywords_ar')->nullable();
            $table->string('short_ar')->after('short')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('keywords');
            $table->dropColumn('keywords_ar');
            $table->dropColumn('short');
            $table->dropColumn('short_ar');
        });
    }
}
