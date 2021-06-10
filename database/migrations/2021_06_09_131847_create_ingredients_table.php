<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('product_code', 5)->comment('P0001');
            $table->string('recipe_code', 5)->comment('RC001');
            $table->string('name', 50);
            $table->text('dose')->comment('Takaran');
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
        Schema::dropIfExists('ingredients');
    }
}
