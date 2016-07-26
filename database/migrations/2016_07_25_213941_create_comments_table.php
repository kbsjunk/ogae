<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->unsignedInteger('words')->default(0);
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('remote_id')->nullable();
            $table->string('remote_source', 1)->nullable();
            $table->dateTime('posted_at');
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
        Schema::drop('comments');
    }
}
