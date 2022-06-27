<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReceiptInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('receipt_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('receipt_id');
            $table->float('amount',10,2)->default(0);
            $table->float('discount',10,2)->default(0);
            $table->string('notes');

            // $table->float('total')->default(0);

            $table->foreign('invoice_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('receipt_id')->references('id')->on('receipt_headers')->onDelete('cascade');

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
        Schema::dropIfExists('receipt_invoices');
    }
}
