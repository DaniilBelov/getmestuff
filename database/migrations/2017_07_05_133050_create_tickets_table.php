<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id');
            $table->string('email');
            $table->string('subject');
            $table->string('organisation')->nullable();
            $table->text('body');
            $table->tinyInteger('priority')->unsigned()->default(0);
            $table->tinyInteger('type')->unsigned()->default(0);
            $table->integer('user_id')->unsigned()->nullable();
            $table->boolean('is_admin')->unsigned()->default(0);
            $table->string('locale')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
