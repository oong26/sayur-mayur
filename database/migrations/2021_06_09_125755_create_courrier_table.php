<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourrierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courrier', function (Blueprint $table) {
            $table->string('courrier_code', 5)->comment('CC001');
            $table->string('name', 50);
            $table->enum('gender', ['Pria', 'Wanita', 'Lainnya'])->default('Lainnya');
            $table->string('phone', 13)->unique();
            $table->timestamps();

            $table->primary('courrier_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courrier');
    }
}
