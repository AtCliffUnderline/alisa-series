<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('bouquet_flowers', function (Blueprint $table){
//            $table->foreign('bouquet_id')->references('bouquets')->on('id');
//            $table->foreign('flower_id')->references('flowers')->on('id');
//        });
//
//        Schema::table('positions', function (Blueprint $table){
//            $table->foreign('bouquet_id')->references('bouquets')->on('id');
//            $table->foreign('flower_id')->references('flowers')->on('id');
//            $table->foreign('deal_id')->references('deals')->on('id');
//        });
//
//        Schema::table('deals', function (Blueprint $table){
//            $table->foreign('contact_id')->references('contacts')->on('id');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('bouquet_flowers', function (Blueprint $table){
//            $table->dropForeign('bouquet_flowers_bouquet_id_foreign');
//            $table->foreign('bouquet_flowers_flower_id_foreign');
//        });
//
//        Schema::table('positions', function (Blueprint $table){
//            $table->dropForeign('positions_bouquet_id_foreign');
//            $table->dropForeign('positions_flower_id_foreign');
//            $table->dropForeign('positions_deal_id_foreign');
//        });
//
//        Schema::table('deals', function (Blueprint $table){
//            $table->dropForeign('deals_contact_id_foreign');
//        });
    }
}
