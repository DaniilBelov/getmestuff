<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->string('token', 30)->nullable();
            $table->boolean('verified')->default(0);
            $table->float('balance', 255, 2)->unsigned()->default(0);
            $table->tinyInteger('status')->default(1);
            $table->json('address')->nullable();
            $table->boolean('donated')->default(0);
            $table->integer('allowed_wishes')->unsigned()->default(0);
            $table->integer('number_of_wishes')->unsigned()->default(1);
            $table->string('ref_link', 5);
            $table->string('ref_id')->nullable();
            $table->json('achievements');
            $table->integer('priority')->unsigned()->default(0);
            $table->unsignedBigInteger('amount_donated')->default(0);
            $table->unsignedBigInteger('amount_received')->default(0);
            $table->integer('points')->default(0);
            $table->boolean('admin')->default(0);
            $table->string('locale', 2);
            $table->rememberToken();
            $table->timestamps();

            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
