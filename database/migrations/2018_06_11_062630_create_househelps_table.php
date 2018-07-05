<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousehelpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('househelps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('mechanic_id');
            $table->text('comments')->nullable();
            $table->string('previous_jobs')->nullable();
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
        Schema::dropIfExists('househelps');
    }
}
