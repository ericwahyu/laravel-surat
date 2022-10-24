<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_unit', function (Blueprint $table) {
            $table->id();
            $table->string('dosen_id');
            $table->unsignedBigInteger('unit_kerja_id');
            $table->timestamps();

            $table->foreign('dosen_id')->references('id')->on('dosen')->onDelete('cascade');
            $table->foreign('unit_kerja_id')->references('id')->on('unit_kerja')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen_unit');
    }
}
