<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('invoice_code', 16)->comment('INV2021010100001');
            $table->string('product_code', 5)->nullable()->comment('P0001');
            $table->string('recipe_code', 5)->nullable()->comment('RC001');
            $table->tinyInteger('android_user_id', false, true);
            $table->string('courrier_code', 5)->comment('CC001');
            $table->tinyInteger('qty');
            $table->bigInteger('total_price');
            $table->enum('type', ['Product', 'Recipe'])->comment('tipe transaksi');
            $table->timestamps();

            $table->foreign('invoice_code')->references('invoice_code')->on('transactions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('product_code')->references('product_code')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('recipe_code')->references('recipe_code')->on('recipe')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('android_user_id')->references('id')->on('android_users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('courrier_code')->references('courrier_code')->on('courrier')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transactions');
    }
}
