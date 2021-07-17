<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorit', function (Blueprint $table) {
            $table->id();
            $table->string('recipe_code', 5)->comment('RC001');
            $table->tinyInteger('android_user_id', false, true);
            $table->timestamps();

            $table->foreign('recipe_code')->references('recipe_code')->on('recipe')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('android_user_id')->references('id')->on('android_users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorit');
    }
}
