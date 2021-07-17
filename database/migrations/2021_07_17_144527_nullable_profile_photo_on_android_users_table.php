<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableProfilePhotoOnAndroidUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('android_users', function (Blueprint $table) {
            $table->text('profile_photo')->nullable()->after('phone')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('android_users', function (Blueprint $table) {
            $table->text('profile_photo')->after('phone'); 
        });
    }
}
