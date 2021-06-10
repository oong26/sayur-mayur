<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('invoice_code', 16)->primary()->comment('INV2021010100001');
            $table->tinyInteger('payment_gateway_id', false, true)->nullable()->default(0);
            $table->bigInteger('total_price');
            $table->bigInteger('total_pay');
            $table->bigInteger('charge');
            $table->text('proof_of_payment')->comment('Bukti Pembayaran');
            $table->timestamps();

            $table->foreign('payment_gateway_id')->references('id')->on('payment_gateway')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
