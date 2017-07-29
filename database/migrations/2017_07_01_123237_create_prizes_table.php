<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('price');
            $table->integer('bought');
            $table->string('user_column');
            $table->timestamps();
        });

        Schema::create('prize_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prize_id')->unsigned();
            $table->string('locale')->index();

            $table->string('item');
            $table->string('description');

            $table->unique(['prize_id', 'locale']);
            $table->foreign('prize_id')->references('id')->on('prizes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prize_translations');
        Schema::dropIfExists('prizes');
    }
}
