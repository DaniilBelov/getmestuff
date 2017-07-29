<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('url', 255);
            $table->json('address');
            $table->float('initial_amount', 255, 2)->unsigned();
            $table->float('amount_needed', 255, 2)->unsigned();
            $table->float('current_amount', 255, 2)->unsigned()->default(0);
            $table->tinyInteger('priority')->unsigned()->default(1);
            $table->boolean('validated')->unsigned()->default(1);
            $table->boolean('completed')->unsigned()->default(0);
            $table->json('donated')->nullable();
            $table->json('reported')->nullable();
            $table->boolean('processed')->default(0);
            $table->timestamps();
        });

        Schema::create('wish_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wish_id')->unsigned();
            $table->string('locale')->index();

            $table->string('item', 255);

            $table->unique(['wish_id', 'locale']);
            $table->foreign('wish_id')->references('id')->on('wishes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wish_translations');
        Schema::dropIfExists('wishes');
    }
}
