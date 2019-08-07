<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenresAndUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::create('series_genres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('series_id');
            $table->unsignedBigInteger('genre_id');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('yandex_user_id');
        });

        Schema::create('user_series', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('series_id');
            $table->boolean('is_favourite');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_series');
        Schema::dropIfExists('users');
        Schema::dropIfExists('series_genres');
        Schema::dropIfExists('genres');
    }
}
