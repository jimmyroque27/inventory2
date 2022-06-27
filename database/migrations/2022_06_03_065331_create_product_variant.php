<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('product_variants', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->unsignedBigInteger('product_id');
             $table->string('variant');
             $table->string('color');
             $table->string('size');
             $table->float('buying_price');
             $table->float('selling_price');
             $table->float('onhand');
             $table->dateTime('start_date');
             $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
         Schema::dropIfExists('product_variants');
     }
}
