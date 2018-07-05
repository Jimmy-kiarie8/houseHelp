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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('verifyToken')->nullable();
            $table->string('phone')->nullable();
            $table->text('location')->nullable();
            $table->string('id_no')->nullable();
            $table->string('status')->nullable();
            $table->string('current_status')->nullable();
            $table->string('current_location')->nullable();
            $table->string('cv')->nullable();
            $table->string('good_coduct')->nullable();
            $table->string('rating')->nullable();
            $table->integer('age')->nullable();
            $table->string('profile')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('locality')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
