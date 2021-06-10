<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe', function (Blueprint $table) {
            $table->string('recipe_code', 5)->comment('RC001');
            $table->string('name', 50);
            $table->text('cover');
            $table->bigInteger('price');
            $table->tinyInteger('stock');
            $table->tinyInteger('is_visible')->default(0)->comment('0=nonaktif,1=aktif');
            $table->timestamps();

            $table->primary('recipe_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe');
    }
}
