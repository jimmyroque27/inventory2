<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('payment_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('paytype_id');
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->float('amount',10,2)->default(0);
            $table->string('refno')->nullable();
            $table->string('refdate')->nullable();
            $table->string('refname')->nullable();=;
            $table->string('approval_id')->nullable();
            $table->string('approval_date')->nullable();
            // $table->float('total')->default(0);

            $table->foreign('purchase_id')->references('id')->on('purchase_headers')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payment_headers')->onDelete('cascade');
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
        Schema::dropIfExists('payment_details');
    }
}
