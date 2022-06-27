<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReceiptDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('receipt_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('receipt_id');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('paytype_id');
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->float('amount',10,2)->default(0);
            $table->string('refno')->nullable();
            $table->string('refdate')->nullable();
            $table->string('refname')->nullable();
            $table->string('approval_id')->nullable();
            $table->string('approval_date')->nullable();
            // $table->float('total')->default(0);
 
            $table->foreign('receipt_id')->references('id')->on('receipt_headers')->onDelete('cascade');
            $table->foreign('paytype_id')->references('id')->on('payment_types')->onDelete('cascade');
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
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
        Schema::dropIfExists('receipt_details');
    }
}
