<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('colors', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->string('name');
             // $table->foreign('color')->references('name')->on('product_variants')->onDelete('cascade');
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
         Schema::dropIfExists('colors');
     }
}
