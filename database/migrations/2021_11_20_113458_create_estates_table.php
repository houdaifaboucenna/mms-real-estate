<?php

use App\Models\CityTown;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->unique();
            $table->text('content');
            $table->string('title_ar')->unique();
            $table->text('content_ar');
            $table->string('short');
            $table->string('short_ar');
            $table->string('keywords')->nullable();
            $table->string('keywords_ar')->nullable();
            $table->integer('type');
            $table->foreignIdFor(CityTown::class, 'town_id')->constrained()->cascadeOnDelete();
            $table->float('min')->nullable()->default(0);
            $table->float('max')->nullable()->default(0);
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estates');
    }
}
