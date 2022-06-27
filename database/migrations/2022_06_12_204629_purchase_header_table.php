<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PurchaseHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('purchase_headers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('refno');
            $table->string('purchase_date');
            $table->string('due_date');
            $table->text('purchase_status');
            $table->float('amount',10,2);
            $table->float('vat',10,2);
            $table->float('total',10,2);
            $table->string('payment_status');
            $table->float('paidamt',10,2)->default(0);
            $table->float('balance',10,2)->default(0);
            $table->integer('finalized')->default(0);
            $table->string('finalized_date');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
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
        Schema::dropIfExists('purchase_headers');
    }
}
