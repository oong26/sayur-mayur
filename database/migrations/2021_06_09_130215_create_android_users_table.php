<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAndroidUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('android_users', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50);
            $table->enum('gender', ['Pria', 'Wanita', 'Lainnya'])->default('Lainnya');
            $table->text('address')->nullable();
            $table->string('email', 50)->unique();
            $table->string('username', 30)->nullable()->unique();
            $table->string('password', 60);
            $table->string('phone', 13)->unique();
            $table->text('profile_photo');
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
        Schema::dropIfExists('android_users');
    }
}
