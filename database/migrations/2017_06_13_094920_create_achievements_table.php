<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('need');
            $table->mediumInteger('prize');
            $table->tinyInteger('renew');
            $table->integer('type');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('achievement_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('achievement_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title');
            $table->string('description');

            $table->unique(['achievement_id', 'locale']);
            $table->foreign('achievement_id')->references('id')->on('achievements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievement_translations');
        Schema::dropIfExists('achievements');
    }
}
