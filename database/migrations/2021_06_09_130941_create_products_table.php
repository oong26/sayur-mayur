<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_code', 5)->comment('P0001');
            $table->string('name', 50);
            $table->string('supplier_code', 5);
            $table->text('cover');
            $table->bigInteger('price');
            $table->tinyInteger('stock');
            $table->tinyInteger('is_visible')->default(0)->comment('0=nonaktif,1=aktif');
            $table->timestamps();

            $table->primary('product_code');
            $table->foreign('supplier_code')->references('supplier_code')->on('supplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
