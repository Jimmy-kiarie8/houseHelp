<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMjobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mjobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('mechanic_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('rating')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('mjobs');
    }
}
