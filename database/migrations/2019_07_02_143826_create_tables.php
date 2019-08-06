<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flowers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedSmallInteger('amount');
            $table->unsignedSmallInteger('price');
            $table->string('photo_url')->nullable();
        });

        Schema::create('bouquets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedSmallInteger('amount');
            $table->unsignedSmallInteger('price');
            $table->string('photo_url')->nullable();
            $table->dateTime('created_at');
        });

        Schema::create('bouquet_flowers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('flower_id')->nullable();
            $table->unsignedBigInteger('bouquet_id')->nullable();
            $table->unsignedSmallInteger('amount');
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('bonus');
        });

        Schema::create('deals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->dateTime('created_at');
            $table->unsignedTinyInteger('payment_type');
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('deal_id');
            $table->unsignedBigInteger('flower_id')->nullable();
            $table->unsignedBigInteger('bouquet_id')->nullable();
            $table->unsignedSmallInteger('amount');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
        Schema::dropIfExists('deals');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('bouquet_flowers');
        Schema::dropIfExists('bouquets');
        Schema::dropIfExists('flowers');
    }
}
