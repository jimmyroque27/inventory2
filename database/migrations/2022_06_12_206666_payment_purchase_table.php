<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('payment_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('payment_id');
            $table->float('amount',10,2)->default(0);
            $table->float('discount',10,2)->default(0);
            $table->string('notes');

            // $table->float('total')->default(0);

            $table->foreign('purchase_id')->references('id')->on('purchase_headers')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payment_headers')->onDelete('cascade');

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
        Schema::dropIfExists('payment_purchases');
    }
}
