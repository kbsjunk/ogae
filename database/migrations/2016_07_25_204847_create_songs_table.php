<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('performer')->nullable();
            $table->string('country')->nullable();
            $table->text('lyrics')->nullable();
            $table->unsignedInteger('number')->nullable();
            $table->unsignedInteger('semifinal')->nullable();
            $table->unsignedInteger('semi_order')->nullable();
            $table->unsignedInteger('semi_points')->nullable();
            $table->unsignedInteger('semi_place')->nullable();
            $table->unsignedInteger('final_order')->nullable();
            $table->unsignedInteger('final_points')->nullable();
            $table->unsignedInteger('final_place')->nullable();
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
        Schema::drop('songs');
    }
}
