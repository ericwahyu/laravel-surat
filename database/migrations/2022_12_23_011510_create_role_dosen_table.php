<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_dosen', function (Blueprint $table) {
            $table->id();
            $table->string('dosen_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            $table->foreign('dosen_id')->references('id')->on('dosen');
            $table->foreign('role_id')->references('id')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen_role');
    }
}
