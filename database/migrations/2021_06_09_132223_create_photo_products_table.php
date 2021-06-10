<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_products', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('product_code', 5)->nullable()->comment('P0001');
            $table->string('recipe_code', 5)->nullable()->comment('RC001');
            $table->text('file_url');
            $table->timestamps();

            $table->foreign('product_code')->references('product_code')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('recipe_code')->references('recipe_code')->on('recipe')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_products');
    }
}
